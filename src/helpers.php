<?php
use Illuminate\Support\Debug\Dumper;

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