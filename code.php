<?php

/**
 * Tattonote v0.5 Public Preview
 * Based on DBMotion 1.2.0
 * 
 * @author Diamochang (Mike Wang) <diamochang@skiff.com>
 * @copyright Copyright (C) Diamochang (Mike Wang), 2024.
 * @license Apache-2.0
 */
require_once('conn.php');
require_once('settings.php');

use core\Engine;

require_once('error_engine.php');
(new Engine())->error();
?>
<!DOCTYPE html>
<html lang="zh-CN" class="mdui-theme-auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" />
    <meta name="renderer" content="webkit" />
    <meta name="force-rendering" content="webkit" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="stylesheet" href="https://unpkg.com/mdui@2.0.3/mdui.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <script src="https://unpkg.com/mdui@2.0.3/mdui.global.js"></script>
    <title>附记查找 - <?php echo constant("TATTONOTE_SITE_NAME"); ?></title>
</head>

<body>
    <mdui-layout>
        <mdui-top-app-bar>
            <mdui-button-icon icon="menu--rounded" href="javascript:;" class="menu-button"></mdui-button-icon>
            <mdui-top-app-bar-title><?php echo constant("TATTONOTE_SITE_NAME"); ?></mdui-top-app-bar-title>
            <mdui-dropdown>
                <mdui-button-icon icon="more_vert--rounded" slot="trigger"></mdui-button-icon>
                <mdui-menu>
                    <mdui-list-item headline="刷新" icon="refresh--rounded" onclick="javascript:location.reload()"></mdui-list-item>
                    <mdui-list-item headline="返回前一页" icon="arrow_back--rounded" onclick="javascript:history.back();"></mdui-list-item>
                    <mdui-list-item headline="开源仓库" icon="folder--rounded" href="https://github.com/Diamochang/tattonote"></mdui-list-item>
                </mdui-menu>
                <mdui-dropdown>
        </mdui-top-app-bar>
        <mdui-navigation-drawer close-on-esc close-on-overlay-click class="menu">
            <mdui-list>
                <mdui-list-item headline="首页" icon="home--rounded" href="index.php"></mdui-list-item>
                <mdui-list-item headline="附记查找" icon="note--rounded" href="code.php" active></mdui-list-item>
                <mdui-list-item headline="关于" icon="info--rounded" href="about.php"></mdui-list-item>
                <mdui-list-item headline="意见反馈" icon="feedback--rounded" href="#"></mdui-list-item>
            </mdui-list>
        </mdui-navigation-drawer>
        <script>
            const navigationDrawer = document.querySelector(".menu");
            const openButton = document.querySelector(".menu-button");

            let isOpen = false;

            openButton.addEventListener("click", () => {
                if (!isOpen) {
                    navigationDrawer.open = true;
                    isOpen = true;
                } else {
                    navigationDrawer.open = false;
                    isOpen = false;
                }
            });
        </script>
        <mdui-layout-main>
            <div class="mdui-prose">
                <h2>附记查找</h2>
                <p>通过此页面快速查找并通过确认码直接阅读附记。</p>
                <?php
                if (isset($_GET['from']) && $_GET['from'] === "QR") {
                    echo "<p><u>温馨提示：请在附记标签上查找附记编号和确认码。</u></p>";
                } else {
                    echo "";
                }
                ?>
            </div>
            <form action="read.php" method="post">
                <mdui-text-field label="附记编号" helper="请连同“N”一同输入。" name="id" required></mdui-text-field>
                <mdui-text-field label="确认码" helper="确认码区分大小写，请仔细核对。" name="code"></mdui-text-field>
                <mdui-button end-icon="arrow_forward--rounded" type="submit">查阅</mdui-button>
            </form>
            <div class="mdui-prose" style="text-align: center;">
                <p><a href="https://www.apache.org/licenses/LICENSE-2.0.html" target="_blank" rel="license noopener noreferrer">许可证</a> | <a href="#" rel="blog">博客</a> | 由 Tattonote 驱动</p>
            </div>
        </mdui-layout-main>
    </mdui-layout>
</body>

</html>