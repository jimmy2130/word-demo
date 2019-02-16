<!-- mysql 中文設定 參考資料 -->
<!-- https://www.ptt.cc/bbs/PHP/M.1460740246.A.F5C.html -->

<?php

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "gendoc1";

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
$conn->set_charset("utf8");