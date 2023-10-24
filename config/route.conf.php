<?php
/**
 * @author Dawnc
 * @date   2023-07-28
 */

use App\Control\Admin\AdminControl;
use App\Control\Admin\AdminRoleControl;
use App\Control\Admin\LoginControl;
use App\Control\Admin\PassportControl;
use App\Control\Admin\RoutesControl;

return [
    // 'url 可用正则' => ['c' => [Control, method], 'm' => '方法'];
    '/login' => ['c' => [LoginControl::class, 'login']],
    '/logout' => ['c' => [LoginControl::class, 'logout']],
    '/user/info' => ['c' => [LoginControl::class, 'userInfo']],
    '/user/permission' => ['c' => [LoginControl::class, 'permission']],
    '/user/menu' => ['c' => [RoutesControl::class, 'menu']],

    '/routes/index' => ['c' => [RoutesControl::class, 'index']],
    '/routes/update' => ['c' => [RoutesControl::class, 'update']],
    '/routes/add' => ['c' => [RoutesControl::class, 'add']],
    '/routes/delete' => ['c' => [RoutesControl::class, 'delete']],


    '/admin/index' => ['c' => [AdminControl::class, 'index']],
    '/admin/add' => ['c' => [AdminControl::class, 'add']],
    '/admin/edit' => ['c' => [AdminControl::class, 'edit']],
    '/admin/del' => ['c' => [AdminControl::class, 'del']],
    '/admin/pass' => ['c' => [AdminControl::class, 'pass']],
    '/admin/enabled' => ['c' => [AdminControl::class, 'enabled']],

    '/role/index' => ['c' => [AdminRoleControl::class, 'index']],

    '/user/password' => ['c' => [PassportControl::class, 'changePassword']],


];
