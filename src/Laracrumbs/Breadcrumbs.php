<?php
/**
 * Created by IntelliJ IDEA.
 * User: David
 * Date: 19/05/2017
 * Time: 11:12
 */

namespace Laracrumbs;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Route as RouteFacade;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Breadcrumbs
{
    /**
     * @var array
     */
    private static $crumbs = [];

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Route
     */
    private $route;

    /**
     * @var array
     */
    private $parameters;

    /**
     * Breadcrumbs constructor.
     * @param Request $request
     */
    private function __construct(Request $request)
    {
        $this->request = $request;
        $this->route = $this->getRequestRoute($request);
    }

    /**
     * @param Route    $route
     * @param callable $callback
     */
    public static function add(Route $route, callable $callback)
    {
        self::$crumbs[$route->uri()] = $callback;
    }

    /**
     * @return array
     */
    public static function getAll(): array
    {
        return self::$crumbs;
    }

    /**
     * @param Request $request
     * @return array
     */
    public static function generate(Request $request): array
    {
        return (new self($request))->get();
    }

    /**
     * @return array
     */
    private function get(): array
    {
        $path = $this->request->getPathInfo();
        $data = [];
        $end = false;

        while (!$end) {
            $path = preg_replace('/\/[^\/]+$/', '', $path);

            //last segment of the path = home page
            if (empty($path)) {
                $end = true;
                $path = '/';
            }

            if ($path && ($route = $this->getPathRoute($path)) && $this->exists($route)) {
                $title = $this->getRouteTitle($route);

                $data[$this->url($path)] = $title;
            }
        }

        return array_reverse($data);
    }

    /**
     * @param string $path
     * @return Route|null
     */
    private function getPathRoute(string $path): ?Route
    {
        $duplicate = $this->request->duplicate(null, null, null, null, null, [
            'REQUEST_URI'    => $path,
            'REQUEST_METHOD' => 'GET'
        ]);

        return $this->getRequestRoute($duplicate);
    }

    /**
     * @param Request $request
     * @return Route|null
     */
    private function getRequestRoute(Request $request): ?Route
    {
        try {
            $route = RouteFacade::getRoutes()->match($request);
        } catch (NotFoundHttpException $e) {
            $route = null;
        }

        return $route;
    }

    /**
     * @param Route $route
     * @return bool
     */
    private function exists(Route $route): bool
    {
        return array_key_exists($route->uri(), self::$crumbs);
    }

    /**
     * @param Route $route
     * @return string
     */
    private function getRouteTitle(Route $route): string
    {
        $callback = self::$crumbs[$route->uri()];

        return $this->runCallback($route, $callback);
    }

    /**
     * @param Route    $route
     * @param callable $callback
     * @return string
     */
    private function runCallback(Route $route, callable $callback): string
    {
        $parameters = $this->getParameters();

        if ($callback instanceof \Closure) {
            $parameters = $route->resolveMethodDependencies($parameters, new \ReflectionFunction($callback));
        } else {
            $method = (is_array($callback)) ? new \ReflectionMethod($callback[0],
                $callback[1]) : new \ReflectionMethod($callback);

            $parameters = $route->resolveMethodDependencies($parameters, $method);
        }

        return $callback(...array_values($parameters));
    }

    /**
     * @return array
     */
    private function getParameters()
    {
        if (empty($this->parameters)) {
            RouteFacade::substituteBindings($this->route);
            RouteFacade::substituteImplicitBindings($this->route);

            $this->parameters = $this->route->parametersWithoutNulls();
        }

        return $this->parameters;
    }

    /**
     * @param $path
     * @return string
     */
    private function url($path)
    {
        if (function_exists('url')) {
            return url($path);
        }

        return (new UrlGenerator(RouteFacade::getRoutes(), $this->request))->to($path);
    }
}