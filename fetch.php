<?php
/**
 * Created by PhpStorm.
 * User: outstudio
 * Date: 16/5/29
 * Time: 上午10:06
 */

function get_content($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $rs = curl_exec($ch); //执行cURL抓取页面内容
    curl_close($ch);
    $fp=fopen("./log.html","w");
    fwrite($fp,$rs);
    fclose($fp);
    return $rs;
}

