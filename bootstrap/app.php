<?php

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CheckLeadAssociation;
use App\Http\Middleware\CheckLeadAssociationByQuot;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias([
            'guest' => RedirectIfAuthenticated::class,
            'auth' => Authenticate::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
            'check.lead' => CheckLeadAssociation::class,
            'check.lead.quot' => CheckLeadAssociationByQuot::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
