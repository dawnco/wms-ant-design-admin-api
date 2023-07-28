<?php
/**
 * @author Dawnc
 * @date   2023-07-28
 */

namespace App\Control;

use Wms\Fw\Request;

class Control
{

    /**
     * @var Request
     */
    protected Request $request;

    public function __construct($request)
    {
        $this->request = $request;
        $this->init();
    }

    protected function init(): void
    {

    }

}
