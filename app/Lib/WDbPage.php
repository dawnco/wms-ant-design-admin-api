<?php

declare(strict_types=1);

/**
 * @author Dawnc
 * @date   2023-10-24
 */

namespace App\Lib;

use Wms\Database\Query;
use Wms\Database\WDbConnect;

class WDbPage
{

    public function __construct(protected WDbConnect $db)
    {

    }

    public function pageData(
        $table,
        int $page = 1,
        int $pageSize = 20,
        array $where = [],
        string $field = "*",
        string $order = ''
    ): array {

        $sql = "SELECT count(*) FROM $table";
        $query = new Query($sql);

        foreach ($where as $v) {
            $query->where($v[0], $v[1], $v[2] ?? null);
        }

        if ($order) {
            $query->order($order);
        }

        [$sql, $params] = $query->getQuery();

        $total = $this->db->getVar($sql, $params);

        $sql = "SELECT $field FROM $table";
        $query->setSql($sql);
        $query->limit(($page - 1) * $pageSize, $pageSize);
        [$sql, $params] = $query->getQuery();

        $data = $this->db->getData($sql, $params);

        return [
            "items" => $data,
            "total" => $total,
        ];

    }
}
