<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
	/**
	 * The application's route middleware aliases.
	 *
	 * @var array<string, class-string|string>
	 */
	protected $middlewareAliases = [
		// ... existing code ...
		'auth' => \App\Http\Middleware\Authenticate::class,
		'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
		'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
		'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
		'can' => \Illuminate\Auth\Middleware\Authorize::class,
		'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
		'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
		'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
		'signed' => \App\Http\Middleware\ValidateSignature::class,
		'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
		'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
		// Use Spatie's provided role middleware for robust resolution in all environments
		'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
		'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
		'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
	];

    /**
     * Backward-compatible route middleware map (some packages still reference this).
     *
     * @var array<string, class-string|string>
     */
	protected $routeMiddleware = [
		'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
		'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
		'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
	];
}
