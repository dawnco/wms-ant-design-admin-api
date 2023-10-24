<?php

declare(strict_types=1);

/**
 * @author Hi Developer
 * @date   2022-05-24
 */

namespace App\Control\Admin;

use App\Control\Control;
use App\Exception\AppException;
use App\Lib\ArrUtil;
use App\Lib\IdGenerator;

use App\Lib\StringUtil;
use Wms\Database\Query;
use Wms\Fw\WDb;

class RoutesControl extends Control
{

    public function index()
    {

        $name = $this->input('name');

        $sql = "SELECT `id` AS `id`,
`parent_id` AS `parentId`,
`path` AS `path`,
`name` AS `name`,
`component` AS `component`,
`redirect` AS `redirect`,
`icon` AS `icon`,
`title` AS `title`,
`status` AS `status`,
`permission` AS `permission`,
`sort` AS `sort`,
`keep_alive` AS `keepAlive`,
`carry_param` AS `carryParam`,
`show_breadcrumb` AS `showBreadcrumb`,
`show_children_in_menu` AS `showChildrenInMenu`,
`current_active_menu` AS `currentActiveMenu`,
`show_tab` AS `showTab`,
`show_menu` AS `showMenu`
FROM admin_routes";

        $query = new Query($sql);
        $query->where(
            "AND (title LIKE ? OR name LIKE ?)",
            ["%$name%", "%$name%"],
            (bool)$name,
        );

        [$sql, $params] = $query->order("sort ASC")->getQuery();

        $data = WDb::getData($sql, $params);
        $items = [];
        foreach ($data as $v) {
            $items[] = [
                'id' => (string)$v->id,
                'parentId' => (string)$v->parentId,
                'path' => $v->path,
                'name' => $v->name,
                'component' => $v->component,
                'sort' => $v->sort,
                'permission' => $v->permission,
                'icon' => $v->icon,
                'redirect' => $v->redirect,
                'title' => $v->title,
                'keepAlive' => (int)$v->keepAlive,
                'status' => (int)$v->status,
                'carryParam' => (int)$v->carryParam,
                'showBreadcrumb' => (int)$v->showBreadcrumb,
                'showChildrenInMenu' => (int)$v->showChildrenInMenu,
                'currentActiveMenu' => $v->currentActiveMenu,
                'showTab' => (int)$v->showTab,
                'showMenu' => (int)$v->showMenu,
            ];
        }
        return ArrUtil::toTreeArr($items, 'id', 'parentId');
    }

    public function add()
    {

        if ($this->valueExist('path', $this->input('path'))) {
            throw new AppException("路由地址已经存在");
        }

        if ($this->valueExist('name', $this->input('name'))) {
            throw new AppException("路由名称已经存在");
        }

        $row = $this->getRow();
        $row['created'] = time();
        WDb::insert('admin_routes', $row);
    }

    public function update()
    {

        if (!$this->input('id')) {
            throw new AppException("ID 不能为空");
        }

        if ($this->valueExist('path', $this->input('path'), $this->input('id'))) {
            throw new AppException("路由地址已经存在");
        }

        if ($this->valueExist('name', $this->input('name'), $this->input('id'))) {
            throw new AppException("路由名称已经存在");
        }

        $row = $this->getRow();
        WDb::update('admin_routes', $row, ['id' => $this->input('id')]);
    }

    protected function getRow()
    {
        $row["id"] = $this->input('id') ?: IdGenerator::id();
        $row["parent_id"] = (int)$this->input('parentId');
        $row["path"] = $this->input('path');
        $row["name"] = StringUtil::camelize($this->input('component'), "/");
        $row["component"] = $this->input('component');
        $row["redirect"] = $this->input('redirect');
        $row["icon"] = $this->input('icon');
        $row["title"] = $this->input('title');
        $row["status"] = (int)$this->input('status');
        $row["permission"] = $this->input('permission');
        $row["sort"] = (int)$this->input('sort');
        $row["keep_alive"] = (int)$this->input('keepAlive');
        $row["carry_param"] = (int)$this->input('carryParam');
        $row["show_breadcrumb"] = (int)$this->input('showBreadcrumb');
        $row["show_children_in_menu"] = (int)$this->input('showChildrenInMenu');
        $row["current_active_menu"] = $this->input('currentActiveMenu');
        $row["show_tab"] = (int)$this->input('showTab');
        $row["show_menu"] = (int)$this->input('showMenu');
        $row["updated"] = time();
        return $row;
    }

    protected function valueExist($field, $val, $id = 0)
    {

        $exist = WDb::getVar("SELECT id FROM admin_routes WHERE `$field` = ?", [$val]);

        if (!$exist) {
            return false;
        }

        return !($exist == $id);

    }

    public function delete()
    {
        $id = $this->input('id');

        $exist = WDb::getVar("SELECT id FROM admin_routes WHERE parent_id = ?", [$id]);
        if ($exist) {
            throw new AppException("先删除子类");
        }

        WDb::delete('admin_routes', ['id' => $id]);

    }

    public function menu()
    {

        $sql = "SELECT `id` AS `id`,
                `parent_id` AS `parentId`,
                `path` AS `path`,
                `name` AS `name`,
                `component` AS `component`,
                `redirect` AS `redirect`,
                `icon` AS `icon`,
                `title` AS `title`,
                `status` AS `status`,
                `permission` AS `permission`,
                `sort` AS `sort`,
                `keep_alive` AS `keepAlive`,
                `carry_param` AS `carryParam`,
                `show_breadcrumb` AS `showBreadcrumb`,
                `show_children_in_menu` AS `showChildrenInMenu`,
                `current_active_menu` AS `currentActiveMenu`,
                `show_tab` AS `showTab`,
                `show_menu` AS `showMenu`
                FROM admin_routes
                ORDER BY `sort` ASC";

        $data = WDb::getData($sql);
        $items = [];
        foreach ($data as $v) {
            $items[] = [
                'id' => (string)$v->id,
                'parentId' => $v->parentId,
                'path' => $v->path,
                'name' => $v->name,
                'component' => $v->component,
                'redirect' => $v->redirect,
                'meta' => [
                    'icon' => $v->icon,
                    'title' => $v->title,
                    'keepAlive' => (bool)$v->keepAlive,
                    'hideMenu' => !$v->showMenu,
                    'carryParam' => (bool)$v->carryParam,
                    'hideChildrenInMenu' => !$v->showChildrenInMenu,
                    'currentActiveMenu' => $v->currentActiveMenu,
                    'hideBreadcrumb' => !$v->showBreadcrumb,
                    'hideTab' => !$v->showTab,
                ]
            ];
        }
        return ArrUtil::toTreeArr($items, 'id', 'parentId');
    }

}
