<?php
/**
 * Created by IntelliJ IDEA.
 * User: David
 * Date: 19/05/2017
 * Time: 12:41
 */

namespace Laracrumbs\Tests;

use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Laracrumbs\Breadcrumbs;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class BreadcrumbsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        Route::swap(new Router(new Dispatcher));
    }

    public function testGetAll()
    {
        Breadcrumbs::add($a = Route::get('get-all', function () {
            return 'Get All';
        }), function () {
            return 'Get All';
        });

        $this->assertNotEmpty(Breadcrumbs::getAll());
    }

    public function testGetBreadcrumbs()
    {
        Breadcrumbs::add($a = Route::get('/', function () {
        }), function () {
            return 'Home';
        });

        Breadcrumbs::add($b = Route::get('hello/{id}', function ($id) {
        }), function ($id) {
            return 'Hello ' . $id;
        });

        Breadcrumbs::add($b = Route::get('hello/{id}/world', function ($id) {
        }), function ($id) {
            return 'Hello ' . $id . ' world';
        });

        Breadcrumbs::add($b = Route::get('hello/{id}/world/end', function ($id) {
        }), function ($id) {
            return 'Hello ' . $id . ' world - end';
        });

        $request = Request::createFromBase(SymfonyRequest::create('http://localhost/hello/1/world/end'));

        $breadcrumbs = Breadcrumbs::generate($request);

        $this->assertNotEmpty($breadcrumbs);

        $this->assertContains('Home', $breadcrumbs);
        $this->assertContains('Hello 1', $breadcrumbs);
        $this->assertContains('Hello 1 world', $breadcrumbs);
    }
}