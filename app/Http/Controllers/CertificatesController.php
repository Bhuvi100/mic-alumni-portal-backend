<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Barryvdh\Snappy\Facades\SnappyPdf;

class CertificatesController extends Controller
{
    public function view(Project $project, User $user)
    {
        $mapping = [
            1 => '2017/2017',
            2 => '2018/hw',
            3 => '2018/sw',
            4 => '2019/hw',
            5 => '2019/sw',
            6 => '2020/sw',
            7 => '2020/hw',
            9 => '2022/sw',
            10 => '2022/hw'
        ];

        $current_html = $mapping[$project->initiative_id] ?? false;

        if (!$current_html) {
            return response('Certificate Not Found', 404);
        }

        return SnappyPdf::loadHTML(render_blade_string(file_get_contents(storage_path("certificates/$current_html.html")),
            [
                'participant_name' => $user->name,
                'team_name' => $project->team_name,
                'certificate_url' => route('certificates', [$project, $user])
            ]
        ))
            ->setPaper('a4')->setOrientation('landscape')
            ->setOptions(['margin-top' => 0, 'margin-bottom' => 0, 'margin-left' => 0,'margin-right' => 0])
            ->inline();
    }

    public function download(Project $project, User $user)
    {
        $mapping = [
            1 => '2017/2017',
            2 => '2018/hw',
            3 => '2018/sw',
            4 => '2019/hw',
            5 => '2019/sw',
            6 => '2020/sw',
            7 => '2020/hw',
            9 => '2022/sw',
            10 => '2022/hw'
        ];

        $current_html = $mapping[$project->initiative_id] ?? false;

        if (!$current_html) {
            return response('Certificate Not Found', 404);
        }

        return SnappyPdf::loadHTML(render_blade_string(file_get_contents(storage_path("certificates/$current_html.html")),
            [
                'participant_name' => $user->name,
                'team_name' => $project->team_name,
                'certificate_url' => route('certificates', [$project, $user])
            ]
        ))
            ->setPaper('a4')->setOrientation('landscape')
            ->setOptions(['margin-top' => 0, 'margin-bottom' => 0, 'margin-left' => 0,'margin-right' => 0])
            ->download('certificate.pdf');
    }
}


