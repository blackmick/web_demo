<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-8-13
 * Time: 上午10:56
 */

if (!isset($PHP_AUTH_USER))
{
    header("WWW-Authenticate:Basic realm=\"????\"");
    header("HTTP/1.0 401 Unauthorized");
    echo "身份验证失败，您无权共享网络资源!";
    exit();
}

var_dump($PHP_AUTH_USER);
var_dump($PHP_AUTH_PW);