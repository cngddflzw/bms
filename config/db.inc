<?php
    function init() {
        $host = "localhost";
        $db = "bills";
        $user = "root";
        $passwd = "lewis0913";
        $mysqli = new mysqli($host, $user, $passwd, $db);
        if($mysqli->connect_errno) {
            die("数据库连接失败,错误：{$mysqli->connect_errno} {$mysqli->connect_error}");
        }
        return $mysqli;
    }
