<?php

declare(strict_types=1);

/**
 * @author Dawnc
 * @date   2022-08-12
 */

namespace App\Control\Admin;

use App\Control\Control;
use App\Exception\AppException;
use App\Lib\Util\Session;

class PassportControl extends Control
{
    public function changePassword()
    {
        $oldPassword = $this->request->input('oldPassword');
        $password = $this->request->input('password');
        $password2 = $this->request->input('password2');

        if (!$oldPassword) {
            throw new AppException("当前密码不能为空");
        }
        if (!$password) {
            throw new AppException("新密码不能为空");
        }


        $savePassword = (string)$this->db->getVar("SELECT password FROM admin WHERE id = ?", [Session::get('userId')]);

        if (!password_verify($oldPassword, $savePassword)) {
            throw new AppException("密码错误");
        }

        $this->db->update('admin', ['password' => password_hash($password, PASSWORD_DEFAULT)],
            ['id' => Session::get('userId')]);


    }
}
