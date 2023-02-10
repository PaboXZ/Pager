<?php
	function printThreadNames($db_connection, $user_id)
	{
		try
		{
			if(!$db_query_result = $db_connection->query("SELECT thread_name FROM thread_data INNER JOIN connection_user_thread ON connection_thread_id = thread_id WHERE connection_user_id = '$user_id'"))
			{
				throw new Exception("Błąd połączenia", 1);
			}
			$returnArray = FALSE;
			$db_result = $db_query_result->fetch_all();
			for($i = $db_query_result->num_rows; $i > 0; $i--)
			{
				$returnArray[$i] = $db_result[$i-1][0];
			}
			return $returnArray;
			$db_query_result->close();
		}
		catch(Exception $error)
		{
			return $error->getMessage();
		}
	}

	function printArrayHTML($array, $htmlbefore, $htmlafter)
	{
		$returnVal = "";
		foreach($array as $value)
		{
			$returnVal = $returnVal.$htmlbefore.$value.$htmlafter;
		}
		return $returnVal;
	}

?>