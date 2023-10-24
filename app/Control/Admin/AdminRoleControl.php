<?php

declare(strict_types=1);

namespace App\Control\Admin;


use App\Control\Control;

class AdminRoleControl extends Control
{
    public function index(): array
    {
        $params = $this->request->input();
        return $this->db->getData("SELECT * FROM admin_role");
    }
}
