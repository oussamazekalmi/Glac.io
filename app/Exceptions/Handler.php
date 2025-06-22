<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return response()->view('errors.404', [], 404);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->view('errors.404', [], 404);
        }

        if ($exception instanceof AuthorizationException) {
            return response()->view('errors.403', [], 403);
        }

        if ($exception instanceof HttpException && $exception->getStatusCode() === 403) {
            return response()->view('errors.403', [], 403);
        }

        return parent::render($request, $exception);
    }
}
