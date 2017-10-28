<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel{

    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \App\Http\Middleware\SetAppLanguage::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'             => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic'       => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest'            => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'bitrix.owner'     => \App\Http\Middleware\BitrixOwner::class,
        'module.owner'     => \App\Http\Middleware\ModuleOwner::class,
        'module.developer' => \App\Http\Middleware\ModuleDeveloper::class,
        'module.manager'   => \App\Http\Middleware\ModuleManager::class,
        'admin'            => \App\Http\Middleware\CheckIfAdmin::class,
        'bindings'         => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can'              => \Illuminate\Auth\Middleware\Authorize::class,
        'throttle'         => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    ];
}
