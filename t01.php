<?php
/**
 * Created by PhpStorm.
 * User: outstudio
 * Date: 16/5/22
 * Time: 下午3:52
 */
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost:2222/structor/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output=curl_exec($ch);
curl_close($ch);
$fp = fopen("./index.html", "w");
fwrite($fp, $output);
fclose($fp);

