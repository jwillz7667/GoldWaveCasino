<?php

namespace App\Exceptions;

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

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Handle deprecation notices
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            if ($errno === E_DEPRECATED || $errno === E_USER_DEPRECATED) {
                if (str_contains($errfile, 'vendor/nesbot/carbon') || 
                    str_contains($errstr, 'Return type of Carbon') ||
                    str_contains($errstr, 'Return type of DateTime')) {
                    // Suppress Carbon and DateTime deprecation warnings
                    return true;
                }
            }
            return false; // Let PHP handle other errors
        }, E_DEPRECATED | E_USER_DEPRECATED);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof \ErrorException && 
            ($e->getSeverity() === E_DEPRECATED || $e->getSeverity() === E_USER_DEPRECATED) &&
            (str_contains($e->getFile(), 'vendor/nesbot/carbon') || 
             str_contains($e->getMessage(), 'Return type of Carbon') ||
             str_contains($e->getMessage(), 'Return type of DateTime'))) {
            return response()->view('errors.500', [], 500);
        }

        return parent::render($request, $e);
    }
}
