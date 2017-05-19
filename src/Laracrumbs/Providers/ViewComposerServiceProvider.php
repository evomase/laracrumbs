<?php
/**
 * Created by IntelliJ IDEA.
 * User: David
 * Date: 19/05/2017
 * Time: 11:22
 */

namespace Laracrumbs\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laracrumbs\BreadcrumbsComposer;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composers([
            BreadcrumbsComposer::class => 'layout.html'
        ]);
    }
}