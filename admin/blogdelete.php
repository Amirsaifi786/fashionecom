<?php
	require_once('../config/connection.php');
	
	if(isset($_GET['id']))
	{
		$id = $_GET['id'];
		$sql = "delete from blog where blog_id = $id";
		//echo $sql;
		//die;
		$result = mysqli_query($conn,$sql);
		
		if($result)
		{
			header("Location:blog.php?msg=success");
		}
		else
		{
			header("Location:blog.php?msg=failure");
		}
	}
?>