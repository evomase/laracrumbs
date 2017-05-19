<?php
/**
 * Created by IntelliJ IDEA.
 * User: David
 * Date: 19/05/2017
 * Time: 12:10
 */

namespace Laracrumbs\Tests;

use Illuminate\Support\Facades\Facade;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        Facade::clearResolvedInstances();
    }
}