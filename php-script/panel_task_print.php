<?php
		try
		{
			if(!isset($_SESSION['user_active_thread']))
			{
				throw new Exception();
			}
			
			
			if(!$db_connection = mysqli_connect($db_host, $db_user, $db_password, $db_name))
			{
				throw new Exception("Błąd serwera", 11);
			}
			
			$user_id = $_SESSION['user_id'];
			$user_active_thread = $_SESSION['user_active_thread'];
			
			if(!$db_query_result = $db_connection->query("SELECT task_id, task_title, task_content, task_power FROM task_data WHERE task_user_id = '$user_id' AND task_thread_id = '$user_active_thread' ORDER BY task_power DESC, task_id ASC"))
			{
				throw new Exception("Błąd serwera", 12);
			}
			if(isset($db_connection))
			{
				$db_connection->close();
				
			}
			$task_html = "";
			for($i = $db_query_result->num_rows; $i > 0; $i--)
			{
				$db_result_row = $db_query_result->fetch_assoc();
				
				$temporary_html = '<div class="col-12 col-lg-6">
					<div class="task-show task-power-'.$db_result_row['task_power'].'">
						<div class="row">
							<div class="col-10 col-lg-9 task-title">
								'.$db_result_row['task_title'].'
							</div>
							<div class="task-title-menu offset-1 col-1 offset-lg-1 col-lg-2 col-xl-2" onclick="showTaskMenu(\''.$db_result_row['task_title'].'\')">
								<i class="icon-menu"></i>

							</div>
							<ul class="task-menu-list" id="task-menu-list-'.$db_result_row['task_title'].'">
								<li onclick="deleteTask(\''.$db_result_row['task_title'].'\')">Usuń wpis</li>
							</ul>
						</div>
					</div>
					<div class="task-show task-power-'.$db_result_row['task_power'].'">
						<div class="task-content">
							'.$db_result_row['task_content'].'
						</div>
					</div>
				</div>';
				
				$task_html = $task_html.$temporary_html;
			}
			$db_query_result->close();
		}
		catch(Exception $error)
		{
			echo $error->getMessage();
		}
?>