<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            // API failures are logged once, with safe context, by render().
            if (app()->bound('request') && request()->is('api/v1/*')) {
                return false;
            }
        });
    }

    public function render($request, Throwable $e)
    {
        $response = parent::render($request, $e);
        if (! $request->is('api/v1/*')) {
            return $response;
        }
        $status = $response->getStatusCode();
        $id = $request->attributes->get('request_id') ?? (string) Str::uuid();
        $errors = [
            400 => ['bad_request', 'This request could not be processed.'],
            401 => ['unauthenticated', 'Please sign in to continue.'],
            403 => ['forbidden', 'You do not have access to this content.'],
            404 => ['not_found', 'The requested content could not be found.'],
            413 => ['payload_too_large', 'This request is too large.'],
            419 => ['session_expired', 'Your session has expired. Please sign in again.'],
            422 => ['validation_failed', 'Please check the submitted fields.'],
            429 => ['rate_limited', 'Too many requests. Please try again later.'],
        ];
        [$code, $message] = $errors[$status] ?? ['service_unavailable', 'This service is temporarily unavailable. Please try again.'];
        if ($status >= 500 && ! $request->attributes->get('failure_logged')) {
            $request->attributes->set('failure_logged', true);
            try {
                Log::channel('diagnostics')->error('api_failure', [
                    'request_id' => $id,
                    'route_template' => $request->route()?->uri() ?? 'unmatched',
                    'status' => $status,
                    'exception_class' => get_class($e),
                ]);
            } catch (Throwable) {
                // A broken logger must never replace the original safe response.
            }
        }
        $body = ['message' => $message, 'code' => $code, 'request_id' => $id];
        if ($e instanceof ValidationException) {
            $body['errors'] = $e->errors();
        }
        $safe = response()->json($body, $status)->header('X-Request-ID', $id);
        foreach (['Retry-After', 'Allow', 'WWW-Authenticate'] as $header) {
            if ($response->headers->has($header)) {
                $safe->headers->set($header, $response->headers->get($header));
            }
        }
        return $safe;
    }
}
