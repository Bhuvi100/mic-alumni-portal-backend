<?php

/**
 * @param \Illuminate\Database\Eloquent\Model $base
 * @param \App\Models\User|null $user
 * @param callable|null $condition
 * @return void
 */
function authorize_action(\Illuminate\Database\Eloquent\Model $base,
                          \App\Models\User $user = null,
                          callable $condition = null)
{
    if (auth()->user()->is_admin()) {
        $result = true;
    } elseif (is_callable($condition)) {
        $result = (bool) $condition($base, $user);
    } else {
        $user = is_null($user?->id) ? auth()->user() : $user;

        $result = $base->is_permitted($user);
    }

    if (!$result) {
        abort(403);
    }
}

if (!function_exists('render_blade_string')) {
    /**
     * Render a blade template using string as a source
     * @param string $string
     * @param $data
     * @param $deleteCachedView
     * @return \Illuminate\Support\HigherOrderTapProxy|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    function render_blade_string(string $string, $data = [], $deleteCachedView = false)
    {
        $component = new class($string) extends Illuminate\View\Component {
            protected string $template;

            public function __construct(string $template)
            {
                $this->template = $template;
            }

            public function render()
            {
                return $this->template;
            }
        };

        $view = Illuminate\Container\Container::getInstance()
            ->make(Illuminate\Contracts\View\Factory::class)
            ->make($component->resolveView(), $data);

        return tap($view->render(), function () use ($view, $deleteCachedView) {
            if ($deleteCachedView) {
                unlink($view->getPath());
            }
        });
    }
}
