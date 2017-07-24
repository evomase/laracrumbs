<?php
/**
 * Created by IntelliJ IDEA.
 * User: David
 * Date: 19/05/2017
 * Time: 13:09
 */

namespace Laracrumbs\Providers;

use Illuminate\Support\AggregateServiceProvider;
use Laracrumbs\Breadcrumbs;

class ServiceProvider extends AggregateServiceProvider
{
    protected $providers = [
        ViewComposerServiceProvider::class
    ];

    public function boot()
    {
        $this->loadViewsFrom(LARACRUMBS_BASE_DIR . '/resources/views', LARACRUMBS_NAME);

        set_exception_handler(function () {
            //disables the generation of breadcrumbs if exception is thrown
            Breadcrumbs::disable();
        });
    }
}