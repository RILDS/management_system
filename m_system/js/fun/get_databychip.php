<?php
    $chip=$_POST['chip'];
	//echo json_encode($chip);
    $condition=$_POST['condition'];
	$arr_condi=$_POST['condition'];
	$arr_condi_split = explode("|", $arr_condi);
	$result_arr_condi_split = count($arr_condi_split);
	require_once("DB_config.php");
    require_once("DB_class.php");

	if($chip!="")
	{

		if($condition != "")
		{
			if($result_arr_condi_split > 1 )
		   {
			$db = new DB();
			$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
			$db->query("
			SELECT *,COUNT(*)from(
			SELECT * from tb_projectdata where _chip='".$chip."'
			UNION ALL
			SELECT * from tb_projectdata where
			_chip  REGEXP '".$condition."'
			OR _project_name REGEXP '".$condition."'
			OR _author REGEXP '".$condition."'
			OR _complete REGEXP '".$condition."'
			)a
			GROUP BY _chip, _project_name, _author, _last_update_date
			HAVING COUNT(*) > 1
			");

		   }else{
			$db = new DB();
			$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
			$db->query("
			SELECT *,COUNT(*)from(
			SELECT * from tb_projectdata where _chip='".$chip."'
			UNION ALL
			SELECT * FROM tb_projectdata WHERE
			_chip  LIKE '%".$condition."%'
			 OR _project_name LIKE '%".$condition."%'
			 OR _author LIKE '%".$condition."%'
			 OR _complete LIKE '%".$condition."%'
			 )a
			GROUP BY _chip, _project_name, _author, _last_update_date
			HAVING COUNT(*) > 1
			");
		    }
		}
		else
		{
			$db = new DB();
			$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
			$db->query("SELECT * from tb_projectdata where _chip='".$chip."'");
		}

	}else {

		if($result_arr_condi_split > 1)
		{
			$db = new DB();
			$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
			$db->query("SELECT * from tb_projectdata where _chip  REGEXP '".$condition."' OR _complete REGEXP '".$condition."' OR _project_name REGEXP '".$condition."' OR _author REGEXP '".$condition."'");

		}
		else
		{
			if($condition =="")
			{
				$db = new DB();
				$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
				$db->query("SELECT * from tb_projectdata");
			}else
			{
				$db = new DB();
				$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
				$db->query("SELECT * FROM tb_projectdata WHERE _chip LIKE '%".$condition."%' OR _complete LIKE '%".$condition."%'  OR _project_name LIKE '%".$condition."%' OR _author LIKE '%".$condition."%'");
			}
		}
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