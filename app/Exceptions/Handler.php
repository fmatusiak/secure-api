<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
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

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof ValidationException) {
            $errors = [];

            foreach ($e->errors() as $field => $messages) {
                $errors[] = [
                    'field' => $field,
                    'messages' => $messages,
                ];
            }

            return response()->json([
                'message' => 'The given data was invalid',
                'errors' => $errors,
            ], 422);
        }

        if ($e instanceof ModelNotFoundException) {
            return response()->json([
                'message' => 'Not found',
                'error' => $e->getMessage()
            ], 404);
        }

        if ($e instanceof Exception) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'An error occurred. Please contact the developer',
            'errors' => $e->getMessage(),
        ], 500);
    }
}
