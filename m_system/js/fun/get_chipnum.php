
<?php
    
    require_once("DB_config.php");
    require_once("DB_class.php");

    $db = new DB();
    $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
    $db->query("SELECT _chip from tb_chip");
  
    //create an array
    $emparray = array();
    while($result = $db->fetch_array())
    {
		$emparray[] = $result;
    }
	echo json_encode($emparray);
	
	//close the db connection
    $db->close_db();
	
?>