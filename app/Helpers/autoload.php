<?php
/**
 * @Author zayn
 * @Date 2020/12/10 15:42
 */

$AutoFiles = scandir(dirname(__FILE__));

// 载入
foreach ($AutoFiles as $FileName) {
    if ($FileName == "." || $FileName == ".." || $FileName == "autoload.php") {
        continue;
    }
    include_once __DIR__ . '/' . $FileName;
}
