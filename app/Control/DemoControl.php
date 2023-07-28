<?php

declare(strict_types=1);

/**
 * @author Dawnc
 * @date   2023-07-28
 */

namespace App\Control;

use App\Exception\AppException;

class DemoControl extends Control
{
    public function index()
    {
        throw new AppException("x");
        return $this->request;
    }
}
