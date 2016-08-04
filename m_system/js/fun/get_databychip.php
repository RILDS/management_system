
<?php
    $chip=$_POST['chip'];
	//echo json_encode($chip);
    $condition=$_POST['condition'];
	require_once("DB_config.php");
    require_once("DB_class.php");

	if($condition != "")
	{
		$db = new DB();
		$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
		$db->query("(SELECT * from tb_projectdata where _chip='".$chip."') UNION (SELECT * FROM tb_projectdata WHERE _chip LIKE '%".$condition."%' OR _project_name LIKE '%".$condition."%' OR _author LIKE '%".$condition."%')");
	}
	else if(($condition =="") && ($chip=="")){
	    $db = new DB();
		$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
		$db->query("SELECT * from tb_projectdata");
	}else
	{	
    $db = new DB();
    $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
    $db->query("SELECT * from tb_projectdata where _chip='".$chip."'");
	}

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