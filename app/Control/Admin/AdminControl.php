<?php

declare(strict_types=1);

/**
 * @author Dawnc
 * @date   2022-05-25
 */

namespace App\Control\Admin;


use App\Control\Control;
use App\Exception\AppException;
use App\Lib\IdGenerator;
use App\Lib\WDbPage;

class AdminControl extends Control
{

    public array $role = ['admin'];

    public function index()
    {
        $page = $this->request->input("page", 1);
        $pageSize = $this->request->input("pageSize", 20);
        $where = [];

        $wDbPage = new WDbPage($this->db);
        $pageData = $wDbPage->pageData('admin a', $page, $pageSize, $where, "*", "a.id DESC");

        $items = $pageData['items'];

        $roles = $this->db->getData("SELECT id, name FROM admin_role");
        $adminRoleRelation = $this->db->getData("SELECT admin_id, role_id FROM admin_role_relation");

        foreach ($items as $o) {
            $roles = $this->getAdminRoles($o->id);
            $o->roleIds = array_column($roles, 'id');
            $o->roleList = $roles;
        }

        return [
            'items' => $items,
            'total' => $pageData['total'],
            'currentPage' => $page,
            'pageSize' => $pageSize
        ];
    }

    protected function getAdminRoles($adminId)
    {

        $adminRoleRelation =
            $this->db->getData("SELECT a.role_id id, r.name FROM admin_role_relation a LEFT JOIN admin_role r ON r.id = a.role_id WHERE admin_id = ?",
                [$adminId]);
        return $adminRoleRelation;


    }

    public function add()
    {
        $row['username'] = $this->request->input('username');
        $row['password'] = password_hash($this->request->input('password'), PASSWORD_DEFAULT);
        $row['name'] = $this->request->input('name');
        $row['phone'] = $this->request->input('phone') ?? '';
        $row['mobile'] = $this->request->input('mobile') ?? '';
        $row['enabled'] = $this->request->input('enabled') ?? 0;
        $currentTime = time();
        $row['created'] = $currentTime;
        $row['updated'] = $currentTime;
        $adminId = $this->db->insertGetId("admin", $row);

        $roleIds = $this->input('roleIds', []);
        $relationData = [];
        foreach ($roleIds as $roleId) {
            $relationData[] = [
                'id' => IdGenerator::id(),
                'admin_id' => $adminId,
                'role_id' => $roleId,
                'created' => time(),
                'updated' => time(),
            ];
        }
        if ($relationData) {
            $this->db->insertBatch('admin_role_relation', $relationData);
        }

    }

    public function edit()
    {
        $adminId = $this->input("id");
        $username = $this->input("username");

        $sql = "SELECT * FROM admin WHERE id = ?";
        $admin = $this->db->getLine($sql, [$adminId]);

        if (!$admin) {
            throw new AppException("记录不存在");
        }
        if (!$username) {
            throw new AppException("用户名不能为空");
        }

        $row['username'] = $this->request->input('username');
        $row['password'] = password_hash($this->request->input('password'), PASSWORD_DEFAULT);
        $row['name'] = $this->request->input('name');
        $row['phone'] = $this->request->input('phone') ?? '';
        $row['mobile'] = $this->request->input('mobile') ?? '';
        $currentTime = time();
        $row['updated'] = $currentTime;
        $this->db->update("admin", $row, ['id' => $adminId]);

        $roleIds = $this->input('roleIds', []);
        $relationData = [];
        foreach ($roleIds as $roleId) {
            $relationData[] = [
                'admin_id' => $adminId,
                'role_id' => $roleId,
                'created' => time(),
                'updated' => time(),
            ];
        }
        if ($relationData) {
            $this->db->delete('admin_role_relation', ['admin_id' => $adminId]);
            $this->db->insertBatch('admin_role_relation', $relationData);
        }


    }

    public function del()
    {
        $adminId = $this->input("id");
        $this->db->delete('admin_role_relation', ['admin_id' => $adminId]);
        $this->db->delete('admin', ['id' => $adminId]);
    }

    public function pass()
    {
        $adminId = $this->input("id");
        $password = $this->input("password");

        $sql = "SELECT * FROM admin WHERE id = ?";
        $admin = $this->db->getLine($sql, [$adminId]);

        if (!$admin) {
            throw new AppException("记录不存在");
        }

        $this->db->update('admin', ['password' => password_hash($password, PASSWORD_DEFAULT)],
            ['id' => $adminId]);

    }

    public function enabled()
    {
        $adminId = $this->input("id");
        $enabled = $this->input("enabled", 0);

        $sql = "SELECT * FROM admin WHERE id = ?";
        $admin = $this->db->getLine($sql, [$adminId]);

        if (!$admin) {
            throw new AppException("记录不存在");
        }

        $this->db->update('admin', ['enabled' => $enabled],
            ['id' => $adminId]);
    }
}
