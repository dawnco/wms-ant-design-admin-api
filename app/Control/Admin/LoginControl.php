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

class LoginControl extends Control
{

    protected function init(): void
    {

    }

    public function login()
    {

        $username = $this->input('username');
        $password = $this->input('password');

        $admin = $this->db->getLine("SELECT id,role,enabled,password,username FROM `admin` WHERE `username`= ?",
            [$username]);

        //判断用户是否存在
        if (!$admin) {
            throw new AppException("帐号不存在");
        }


        if ($admin->enabled == AppConstant::NO) {
            throw new AppException('账号被禁用');
        }


        if (password_verify($password, $admin->password)) {

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
        throw new AppException("密码错误");


    }

    public function logout()
    {

    }

    public function userInfo()
    {
        return [
            'userId' => Session::get("userId"),
            'username' => Session::get("username"),
            'name' => Session::get("name"),
            'avatar' => Session::get("avatar"),
            'desc' => "",
            'password' => '',
            'token' => '',
            'homePath' => '/dashboard/analysis',
            'roles' => [
                //[
                //    'roleName' => 'Super Admin',
                //    'value' => 'super',
                //],
            ],
        ];
    }

    public function permission(): array
    {
        return [
            'content.add',
        ];
    }
}
