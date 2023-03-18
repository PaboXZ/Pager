<?php

	if(count(get_included_files()) == 1)
	{
		exit("Access denied.");
	}

	function getNewNotifications($max_notification_number)
	{
		require_once('php-script/db_connect.php');
		
		try
		{
			if(!$db_connection = db_connect())
				throw new Exception('Usługa niedostępna, przepraszamy.', 11);
			
			if(!$db_result = $db_connection->query("SELECT notification_content FROM notification_data WHERE notification_user_to = '{$_SESSION['user_id']}' AND notification_is_read = '0' LIMIT $max_notification_number"))
				throw new Exception('Usługa niedostępna, przepraszamy.', 12);
			if($db_result->num_rows > 0)
			{
				$db_result = $db_result->fetch_all();
				
				for($i = 0; $i < count($db_result); $i++)
				{
					$db_result[$i] = implode('', $db_result[$i]);
				}
			}
			else
			{
				db_close($db_connection);
				return false;
			}
			db_close($db_connection);
			return $db_result;		
		}
		catch(Exception $error)
		{
			db_close($db_connection);
			return false;
		}
		
		
	}
	
	function notificationWrite($user_to, $user_from, $content)
	{
		require_once('php-script/db_connect.php');
		
		try
		{
			if(!$db_connection = db_connect())
				throw new Exception('Usługa niedostępna, przepraszamy.', 11);
			
			if(!$db_result = $db_connection->query("SELECT user_name FROM user_data WHERE user_id = '$user_from'"))
				throw new Exception('Usługa niedostępna, przepraszamy.', 12);
			
			if($db_result->num_rows != 1)
				throw new Exception('Nie znaleziono użytkownika', 21);
			
			$user_from_name = $db_result->fetch_column();
			
			if(!$db_result = $db_connection->query("SELECT user_name FROM user_data WHERE user_id = '$user_to'"))
				throw new Exception('Usługa niedostępna, przepraszamy.', 12);
			
			if($db_result->num_rows != 1)
				throw new Exception('Nie znaleziono użytkownika', 22);
			
			if(!$db_result = $db_connection->query("SELECT user_ignored FROM user_data WHERE user_id = $user_to"))
				throw new Exception('Usługa niedostępna, przepraszamy.', 12);
			
			if($db_result->num_rows != 1)
				throw new Exception('Usługa niedostępna, przepraszamy.', 13);
			
			$db_result = $db_result->fetch_column();
			
			$db_result = explode(',', $db_result);
			
			foreach($db_result as $ignored_user)
			{
				if($ignored_user == $user_from_name)
					throw new Exception('Zablokowany przez użytkownika', 23);
			}
			
			if(!$db_connection->query("INSERT INTO notification_data (notification_user_to, notification_user_from, notification_content) VALUES ('$user_to', '$user_from', '$content')"))
				throw new Exception('Usługa niedostępna, przepraszamy.', 14);
				
			return 0;
		}
		catch(Exception $error)
		{
			return $error->getCode();
		}
	}



?>