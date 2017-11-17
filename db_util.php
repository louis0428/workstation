<?php 

// Method for execute sql INSERT, UPDATE, DELETE or SELECT.
// Only execute query SELECT will return an array.
// Example for execute SELECT: $a_data = executeSql("SELECT * FROM PEOPLE WHERE id = ? and name = ?", array(1, "Leow"), array("i", "s"));
// Example for execute INSERT: executeSql("INSERT INTO PEOPLE (name, age) VALUES (?, ?)", array("Louis", 22), array("s", "i"));
function executeSql($sql, $a_bind_params, $a_param_type) {
	require_once "conn.php";
	$a_params = array();
	 
	$param_type = '';
	$n = count($a_param_type);
	for($i = 0; $i < $n; $i++) {
	  $param_type .= $a_param_type[$i];
	}
	 
	/* with call_user_func_array, array params must be passed by reference */
	$a_params[] = & $param_type;
	 
	for($i = 0; $i < $n; $i++) {
	  /* with call_user_func_array, array params must be passed by reference */
	  $a_params[] = & $a_bind_params[$i];
	}
	 
	/* Prepare statement */
	$stmt = $conn->prepare($sql);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
	}
	 
	/* use call_user_func_array, as $stmt->bind_param('s', $param); does not accept params array */
	call_user_func_array(array($stmt, 'bind_param'), $a_params);
	 
	/* Execute statement */
	$stmt->execute();

	/* Fetch result to array */
	$a_data = array();
	$res = $stmt->get_result();
	if ($res) {
		while($row = $res->fetch_array(MYSQLI_ASSOC)) {
	  		array_push($a_data, $row);
		}
		return $a_data;
	}

	mysqli_close($conn);
}


?>