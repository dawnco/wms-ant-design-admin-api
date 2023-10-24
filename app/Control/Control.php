<?php
/**
 * @author Dawnc
 * @date   2023-07-28
 */

namespace App\Control;

use Wms\Database\WDbConnect;
use Wms\Fw\Request;
use Wms\Fw\WDb;

class Control
{

    /**
     * @var Request
     */
    protected Request $request;

    protected WDbConnect $db;

    public function __construct($request)
    {
        $this->request = $request;
        $this->init();
    }

    protected function init(): void
    {
        $this->db = WDb::connection();
    }

    protected function input($key = null, $default = '')
    {
        return $this->request->input($key, $default);
    }

    protected function inputArr2Val($key = null, $default = '')
    {
        $val = $this->request->input($key, $default);
        return is_array($val) ? implode("", $val) : $default;
    }

}
