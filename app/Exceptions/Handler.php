<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Throwable;
use Illuminate\Http\Request;
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json(['message' => __('supported.notfound')], 404);
            }
        });
        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json(['message' => __('auth.errors.has_no_permission')], 403);
            }
        });

//        $this->renderable(function (Throwable $e, Request $request) {
//            if ($request->is('api/*')) {
//                return response()->json(['message' => __('supported.server_error')], 500);
//            }
//        });
    }

    // Helper method to check if the exception is a server error
    protected function isServerError(Throwable $e): bool
    {
        return $e instanceof HttpException &&
            $e->getStatusCode() === 500;
    }
}
