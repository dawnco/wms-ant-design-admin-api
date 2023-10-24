<?php

/**
 * Member Global Session Id
 * @author WhoAmI
 * @date   2019-11-09
 */

namespace App\Lib\Util;


use App\Exception\AppException;
use Wms\Fw\Conf;
use Wms\Lib\WRedis;

class SID
{

    protected \Redis $redis;
    protected string $sid = '';
    protected string $innerSid = ''; // 存储的 sid 带前缀
    protected string $prefix = 'redSID:';

    // 过期时间
    protected int $expire = 172800; // s

    public function __construct(string $sid = '')
    {

        $this->sid = $sid;
        $this->innerSid = $this->prefix . $this->sid;
        $this->redis = WRedis::connection();

        if (!$this->exist()) {
            $this->sid = '';
            $this->innerSid = '';
        }
    }

    public function set($key, $val = null)
    {

        if ($this->sid == null) {
            throw new AppException("sid not found");
        }

        if ($val === null) {
            $this->redis->hDel($this->innerSid, $key);
        } else {
            $this->redis->hSet($this->innerSid, $key, json_encode($val));
        }
    }

    public function get($key)
    {

        if ($this->sid == null) {
            return null;
        }

        $data = $this->redis->hGet($this->innerSid, $key);

        return $data ? json_decode($data, true) : null;
    }

    public function remove()
    {
        $id = $this->innerSid;
        $this->redis->unlink($id);
        $this->innerSid = null;
    }

    public function exist()
    {
        return $this->redis->exists($this->innerSid) > 0;
    }

    public function create()
    {
        $sid = md5(uniqid($this->prefix) . microtime(true));
        $this->sid = strtoupper($sid);
        $this->innerSid = $this->prefix . $this->sid;
        $this->redis->del($this->innerSid);
        $this->set('t', time());
        $this->redis->expire($this->innerSid, $this->expire);
        return $this->sid;
    }

    /**
     * 删除上次登录的SID 保留本次的SID
     * @param $memberId
     */
    public function once($memberId)
    {
        if (Conf::get('app.env') == 'dev') {
            return;
        }
        $key = $this->prefix . "once:" . $memberId;
        $lastSid = $this->redis->get($key);
        $r = $this->redis->del($lastSid);
        $this->redis->setEx($key, $this->expire + 10, $this->innerSid);
    }

    public function getSid(): string
    {
        return $this->sid;
    }

    /**
     * 快速生成 APP端 Token
     * @param array $member
     * @return string token
     */
    public function red(array $member = []): string
    {

        $this->create();

        $this->set("userId", $member['userId'] ?? 0);
        $this->set("username", $member['username'] ?? '');
        $this->set("name", $member['name'] ?? '');
        $this->set("avatar", $member['avatar'] ?? '');
        $this->set("role", $member['role'] ?? '');

        if ($member['userId']) {
            $this->once($member['userId']);
        }
        return $this->getSid();
    }

}
