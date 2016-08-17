<?php
    require_once("DB_class.php");

    $chip=$_POST['chip'];
	//echo json_encode($chip);
    $condition=$_POST['condition'];
	$arr_condi=$_POST['condition'];
	$arr_condi_split = explode("|", $arr_condi);
	$result_arr_condi_split = count($arr_condi_split);

	if($chip!="")
	{
		if($condition != "")
		{
            if($result_arr_condi_split > 1 )
            {
                $sql = "
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
                ";
            }
            else
            {
                $sql = "
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
                ";
            }
		}
		else
		{
            $sql = "SELECT * from tb_projectdata where _chip='".$chip."'";
		}
	}
    else
    {
		if($result_arr_condi_split > 1)
		{
			$sql = "SELECT * from tb_projectdata where _chip  REGEXP '".$condition."' OR _complete REGEXP '".$condition."' OR _project_name REGEXP '".$condition."' OR _author REGEXP '".$condition."'";
		}
		else
		{
			if($condition =="")
			{
				$sql = "SELECT * from tb_projectdata";
			}
            else
			{
				$sql = "SELECT * FROM tb_projectdata WHERE _chip LIKE '%".$condition."%' OR _complete LIKE '%".$condition."%'  OR _project_name LIKE '%".$condition."%' OR _author LIKE '%".$condition."%'";
			}
		}
	}

    $db = new DB();
    $db->print_json($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname'], $sql);
?>
