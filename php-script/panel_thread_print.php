<?php
	if(count(get_included_files()) == 1)
	{
		exit("Access denied.");
	}

		try
		{
			$user_id = $_SESSION['user_id'];
			
			require_once("php-script/db_credentials.php");
	
			if(!$db_connection = mysqli_connect($db_host, $db_user, $db_password, $db_name))
			{
				throw new Exception("Błąd serwera", 1);
			}
			
			if(!$db_query_result = $db_connection->query("SELECT thread_id, thread_name FROM connection_user_thread INNER JOIN thread_data ON connection_user_thread.connection_thread_id = thread_data.thread_id WHERE connection_user_thread.connection_user_id = '$user_id'"))
			{
				throw new Exception("Błąd serwera", 2);
			}
			else
			{
				if(!isset($_SESSION['user_active_thread']))
				{
					$_SESSION['user_active_thread'] = 0;
				}
				$thread_html = "";
				$thread_active_name = "";
				
				for($i = $db_query_result->num_rows; $i > 0; $i--)
				{
					$db_result_row = $db_query_result->fetch_assoc();
					
					if($_SESSION['user_active_thread'] == $db_result_row['thread_id'])
					{
						$thread_active_name = $db_result_row['thread_name'];
						$temp_html = '<li class="active-thread"><a href="change_active_thread.php?id='.$db_result_row['thread_id'].'">'.$db_result_row['thread_name']."</a><br></li>";
					}
					else
					{
						$temp_html = '<li class="inactive-thread"><a href="change_active_thread.php?id='.$db_result_row['thread_id'].'">'.$db_result_row['thread_name']."</a><br></li>";
					}
					$thread_html =  $thread_html.$temp_html;
				}
				$db_query_result->close();
				
			}
			
		}
		catch(Exception $error)
		{
			echo $error->getMessage();
		}
?>