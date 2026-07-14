<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        // ============================================
        // 401 Unauthorized
        // ============================================
        if ($exception instanceof AuthenticationException) {
            return response()->view('errors.401', [], 401);
        }

        // ============================================
        // 403 Forbidden
        // ============================================
        if ($exception instanceof AuthorizationException || 
            ($exception instanceof HttpException && $exception->getStatusCode() == 403)) {
            return response()->view('errors.403', [
                'exception' => $exception,
                'title' => 'Access Denied',
            ], 403);
        }

        // ============================================
        // 404 Not Found
        // ============================================
        if ($exception instanceof NotFoundHttpException || 
            $exception instanceof ModelNotFoundException) {
            return response()->view('errors.404', [], 404);
        }

        // ============================================
        // 419 Session Expired
        // ============================================
        if ($exception instanceof TokenMismatchException) {
            return response()->view('errors.419', [], 419);
        }

        // ============================================
        // 429 Too Many Requests
        // ============================================
        if ($exception instanceof HttpException && $exception->getStatusCode() == 429) {
            return response()->view('errors.429', [], 429);
        }

        // ============================================
        // 500 Server Error
        // ============================================
        if ($exception instanceof HttpException && $exception->getStatusCode() == 500) {
            return response()->view('errors.500', [], 500);
        }

        // ============================================
        // 503 Maintenance Mode
        // ============================================
        if ($exception instanceof HttpException && $exception->getStatusCode() == 503) {
            return response()->view('errors.503', [], 503);
        }

        return parent::render($request, $exception);
    }
}