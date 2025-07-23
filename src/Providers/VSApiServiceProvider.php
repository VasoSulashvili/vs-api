<?php

declare(strict_types=1);

namespace VSApi\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Exceptions\Handler;

class VSApiServiceProvider extends ServiceProvider
{

    public function register()
    {

    }

    public function boot()
    {
        app()->make(Handler::class)->renderable(function (\Throwable $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'errors' => []
                ], $e->getStatusCode() ?: 500);
            }
        });
    }

}
