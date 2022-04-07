<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Paginate the given query.
     *
     * @param  int|null  $perPage
     * @param  array  $columns
     * @param  string  $pageName
     * @param  int|null  $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     *
     * @throws \InvalidArgumentException
     */
    public function paginate($query, $perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);

        $perPage = $perPage ?: $query->model->getPerPage();

        $total = User::filter()->distinct()->count('users.id');

        $results = ($total)
            ? $query->forPage($page, $perPage)->get($columns)
            : $query->model->newCollection();

        return $this->paginator($results, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
    }

    /**
     * Create a new length-aware paginator instance.
     *
     * @param  \Illuminate\Support\Collection  $items
     * @param  int  $total
     * @param  int  $perPage
     * @param  int  $currentPage
     * @param  array  $options
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function paginator($items, $total, $perPage, $currentPage, $options)
    {
        return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
            'items', 'total', 'perPage', 'currentPage', 'options'
        ));
    }

    public function index()
    {
        $query = User::filter();

        return response()->json($this->paginate($query, 25, 'users.*'));
    }

    public function exportData()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }


    public function show(?User $user)
    {
        $user = $user->id ? $user : auth()->user();

        return response()->json([
            'user' => $user,
            'projects' => $user->projects()->get()
                ->mapWithKeys(function($project) {
                    $array = [
                        'id' => $project->id,
                        'team_name' => $project->team_name,
                        'title' => $project->title,
                        'initiative' => [
                            'hackathon' => $project->initiative->hackathon,
                            'edition' => $project->initiative->edition
                        ]
                    ];

                    return [$project['id'] => $array];
                }),
        ]);
    }

    public function update(UserUpdateRequest $request)
    {
        $user = auth()->user();

        $data = $request->validated();

        if (!$user->signed_up_at) {
            $data['signed_up_at'] = now();
        }

        if ($request->hasFile('picture')) {
            if ($user->getRawOriginal('picture') != null && Storage::disk('public')->exists($user->getRawOriginal('picture'))) {
                Storage::disk('public')->delete($user->getRawOriginal('picture'));
            }

            $data['picture'] = $request->file('picture')->store('images/users', 'public');
        }

        $user->update($data);

        return response()->json([
            'success' => 1,
            'user' => $user,
        ]);
    }
}