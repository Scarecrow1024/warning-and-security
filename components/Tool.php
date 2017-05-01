<?php

namespace app\components;

use Exception;
use Yii;

/**
 * 常用工具类 CommonTool
 *
 * @package app\components
 *
 * @author Kingfree <kingfree@lonlife.cn>
 * @date 2015-12-14
 */
class Tool
{
    public static function getClientIp()
    {
        // 得到CDN后面的真实IP
        $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
        if ($_SERVER['HTTP_CDN_SRC_IP']) {
            // cdn转发多ip的问题
            if (strpos($_SERVER['HTTP_CDN_SRC_IP'], ",") !== false) {
                $tmp = explode(",", $_SERVER['HTTP_CDN_SRC_IP']);
                $ip = @trim(@array_shift($tmp));
                if (!$ip || $ip == 'unknown') {
                    $ip = @trim(@array_shift($tmp));
                }
            } else {
                $ip = $_SERVER['HTTP_CDN_SRC_IP'];
            }
        }
        if ($_SERVER['HTTP_X_FORWARDED_FOR']) {
            if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ",") !== false) {
                $tmp = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
                $ip = @trim(@array_shift($tmp));
                if (!$ip || $ip == 'unknown') {
                    $ip = @trim(@array_shift($tmp));
                }
            } else {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        }
        return $ip;
    }

}
