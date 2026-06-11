<?php

namespace App\Foundation\Bootstrap;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Bootstrap\HandleExceptions as BaseHandleExceptions;

class HandleExceptions extends BaseHandleExceptions
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        parent::bootstrap($app);

        if (PHP_VERSION_ID >= 80100) {
            error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
        }
    }
}
