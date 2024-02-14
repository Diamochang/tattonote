<?php

/**
 * Tattonote v0.5 Public Preview
 * Based on DBMotion 1.2.0
 * 
 * @author Diamochang (Mike Wang) <diamochang@skiff.com>
 * @copyright Copyright (C) Diamochang (Mike Wang), 2024.
 * @license Apache-2.0
 */

require_once("conn.php");
require_once('settings.php');
require_once("Parsedown.php");

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
    <title>阅读附记 - <?php echo constant("TATTONOTE_SITE_NAME"); ?></title>
</head>

<body>
    <mdui-layout>
        <mdui-top-app-bar>
            <mdui-button-icon icon="menu--outlined" href="javascript:;" class="menu-button"></mdui-button-icon>
            <mdui-top-app-bar-title><?php echo constant("TATTONOTE_SITE_NAME"); ?></mdui-top-app-bar-title>
            <mdui-dropdown>
                <mdui-button-icon icon="more_vert--outlined" slot="trigger"></mdui-button-icon>
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
                <mdui-list-item headline="附记查找" icon="note--rounded" href="code.php"></mdui-list-item>
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
                <h2>阅读附记</h2>
                <mdui-card>
                    <?php
                    try {
                        $Parsedown = new Parsedown();
                        $salt = '5nNrjcQA5l)bwe7OeQ(W';
                        $algorithm =  'DES-EDE-CFB';
                        $ID = $_POST['id'];

                        //参数化查询
                        $stmt = $conn->prepare("SELECT * FROM main WHERE id=?");
                        $stmt->bind_param("s", $ID);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $data = $result->fetch_assoc();
                        $stmt->close();

                        $content = openssl_decrypt($data['content'], $algorithm, $salt, 0);

                        if (isset($ID) && strtoupper($ID) !== strtoupper($data['id'])) {
                            echo <<<HTML
                        <mdui-button href="code.php">没有此附记，点击按钮返回</mdui-button>
                        HTML;
                        } else {
                            if (isset($_POST['code']) && strtoupper($_POST['code']) === strtoupper($data['code'])) {
                                echo "<h3>" . htmlspecialchars($ID) . "<mdui-badge variant='large'>普通附记</mdui-badge></h3>";
                                echo $Parsedown->text($content);
                            } else {
                                if (isset($_POST['code']) && strtoupper($_POST['code']) !== strtoupper($data['code'])) {
                                    echo <<<HTML
                                <mdui-button href="code.php">确认码无效，点击按钮重新输入</mdui-button>
                            HTML;
                                }
                            }
                        }
                    } catch (Exception $e) {
                        echo "<p>发生了错误或没有找到对应数据表。</p>";
                    }
                    ?>
                </mdui-card>
            </div>
            <br>
            <div class="mdui-prose" style="text-align: center;">
                <p><a href="https://www.apache.org/licenses/LICENSE-2.0.html" target="_blank" rel="license noopener noreferrer">许可证</a> | <a href="#" rel="blog">博客</a> | 由 Tattonote 驱动</p>
            </div>
        </mdui-layout-main>
    </mdui-layout>
</body>

</html>