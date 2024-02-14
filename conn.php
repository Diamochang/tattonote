<?php

/**
 * Tattonote v0.5 Public Preview
 * Based on DBMotion 1.2.0
 * 
 * @author Diamochang (Mike Wang) <diamochang@skiff.com>
 * @copyright Copyright (C) Diamochang (Mike Wang), 2024.
 * @license Apache-2.0
 */
require_once('settings.php');

$servername = constant("TATTONOTE_DATABASE_SERVER");
$username = constant("TATTONOTE_DATABASE_USERNAME");
$password = constant("TATTONOTE_DATABASE_PASSWORD");
$dbname = constant("TATTONOTE_DATABASE_NAME");
$ErrorMsg = <<<HTML
<!DOCTYPE html>
<html lang="zh-CN" class="mdui-theme-auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" />
    <meta name="renderer" content="webkit" />
    <meta name="force-rendering" content="webkit" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="stylesheet" href="https://unpkg.com/mdui@2.0.3/mdui.css" />
    <script src="https://unpkg.com/mdui@2.0.3/mdui.global.js"></script>
    <title>数据库连接错误 - Tattonote</title>
</head>

<body>
    <mdui-layout>
        <mdui-layout-main>
            <mdui-card>
                <div class="mdui-prose">
                    <div>
                        <h2>哦豁...</h2>
                        <p>Tattonote 的数据库发生了错误。如果你是访客，请过会时间再试或者向网站管理员报告。如果你是管理员，请立即检查数据库是否存在错误，必要时还需查看<code>conn.php</code>中配置的数据库信息是否正确。</p>
                    </div>
                </div>
                <mdui-button variant="filled" onclick="javascript:location.reload()">刷新</mdui-button>
            </mdui-card>
        </mdui-layout-main>
    </mdui-layout>
</body>

</html>
HTML;
$ConnectErrorMsg = <<<HTML
<!DOCTYPE html>
<html lang="zh-CN" class="mdui-theme-auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" />
    <meta name="renderer" content="webkit" />
    <meta name="force-rendering" content="webkit" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="stylesheet" href="https://unpkg.com/mdui@2.0.3/mdui.css" />
    <script src="https://unpkg.com/mdui@2.0.3/mdui.global.js"></script>
    <title>数据库连接错误 - Tattonote</title>
</head>

<body>
    <mdui-layout>
        <mdui-layout-main>
            <mdui-card>
                <div class="mdui-prose">
                    <div>
                        <h2>哦豁...</h2>
                        <p>Tattonote 无法连接到数据库。如果你是访客，请过会时间再试或者向网站管理员报告。如果你是管理员，请立即检查数据库连接情况，必要时还需查看<code>conn.php</code>中配置的数据库信息是否正确。</p>
                    </div>
                </div>
                <mdui-button variant="filled" onclick="javascript:location.reload()">刷新</mdui-button>
            </mdui-card>
        </mdui-layout-main>
    </mdui-layout>
</body>

</html>
HTML;
// 创建连接
try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 检测连接
    if ($conn->connect_error) {
        die($ConnectErrorMsg);
    }

    // 设置字符集
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    die($ErrorMsg);
}
