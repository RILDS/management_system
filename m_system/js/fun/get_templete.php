<?php
    require_once("DB_class.php");
    $sql = "SELECT _templete_name from tb_templete";
    $db = new DB();
    $db->print_json($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname'], $sql);
?>
