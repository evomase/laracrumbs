<?php
/**
 * Created by IntelliJ IDEA.
 * User: David
 * Date: 24/07/2017
 * Time: 15:27
 */

namespace Laracrumbs\Tests;

use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Laracrumbs\Breadcrumbs;

class ServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        Route::swap(new Router(new Dispatcher));
    }

    public function testBoot()
    {
        try {
            throw new \Exception;
        } catch (\Exception $e) {
            $this->assertEmpty(Breadcrumbs::generate(new Request));
        }
    }
}