<?php
/**
 * Created by IntelliJ IDEA.
 * User: David
 * Date: 19/05/2017
 * Time: 11:23
 */

namespace Laracrumbs;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BreadcrumbsComposer
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('breadcrumbs', Breadcrumbs::generate($this->request));
    }
}