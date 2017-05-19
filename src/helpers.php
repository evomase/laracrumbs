<?php
use Illuminate\Support\Debug\Dumper;

define('LARACRUMBS_BASE_DIR', __DIR__ . '/../');
define('LARACRUMBS_NAME', 'laracrumbs');

if (!function_exists('_dd')) {
    /**
     * @param mixed ...$args
     */
    function _dd(...$args)
    {
        foreach ($args as $arg) {
            (new Dumper())->dump($arg);
        }
    }
}