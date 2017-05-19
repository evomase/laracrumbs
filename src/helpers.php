<?php
use Illuminate\Support\Debug\Dumper;

/**
 * @param mixed ...$args
 */
function _dd(...$args)
{
    foreach ($args as $arg) {
        (new Dumper())->dump($arg);
    }
}