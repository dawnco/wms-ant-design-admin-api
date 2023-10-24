<?php

declare(strict_types=1);

/**
 * @author Dawnc
 * @date   2022-05-25
 */

namespace App\Control\Admin;

use App\Constant\AppConstant;
use App\Control\Control;
use App\Exception\AppException;
use App\Lib\Util\Session;
use App\Service\Admin\Model\AdminModel;

class LoginControl extends Control
{

    public function login(): array
    {

        $username = $this->input('username');
        $password = $this->input('password');

        $admin = $this->db->getLine("SELECT id,role,enabled,password FROM `admin` WHERE `username`= ?", [$username]);

        //判断用户是否存在
        if (!$admin) {
            throw new AppException("帐号不存在");
        }

        //   password_hash('123456', PASSWORD_DEFAULT)

        if ($admin->enabled == AppConstant::NO) {
            throw new AppException('账号被禁用');
        }

        if (password_verify($password, $admin->password)) {
            return $admin;
        } else {
            throw new AppException("密码错误");
        }

        $token = Session::new([
            'userId' => $admin->id,
            'username' => $admin->username,
            'role' => $admin->role
        ]);

        return [
            'userId' => $admin->id,
            'username' => $admin->username,
            'token' => $token,
            'role' => $admin->role
        ];
    }

    public function logout()
    {

    }
}
