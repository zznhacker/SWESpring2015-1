<?php
	start_session();
	include 'functions.php';
	$db = db_connect();

	$sso = $_SESSION['username'];

	#$paw = $_SESSION['username']; // This is how we will get their pawprint/SSO
	#echo $paw;
	
	if( $_POST['selection'] && $_POST['fname'] && $_POST['lname']&& $_POST['gpa']){
		#if(pg_query($db, "SELECT * FROM Applicant WHERE sso = '".$sso."';") == FALSE){
		$temp = pg_query($db, "INSERT INTO Applicant (sso) VALUES ('".$sso."');");
		#}
		pg_query($db, "UPDATE Applicant SET fname = '". $_POST['fname'] ."', lname = '". $_POST['lname'] ."', 
			gpa = '". $_POST['gpa'] ."' WHERE sso = '". $sso ."';");
		if($_POST['selection'] != "TA")
			pg_query($db, "INSERT INTO applicant_is_a_ugrad (sso) VALUES ('".$sso."');");
		else pg_query($db, "INSERT INTO applicant_is_a_grad (sso) VALUES ('".$sso."');");
		
	//	if($temp)
	//	  echo $temp;
	}

	if( $_POST['ID'] && $_POST['selectionmajor'] && $_POST['advisorname'] && $_POST['email'] && $_POST['masterphd']&& $_POST['selection']){
		pg_query($db, "UPDATE Applicant SET id = '". $_POST['ID']."', email = '". $_POST['email']. "' WHERE sso = '".$sso."';");
		if($_POST['selection'] != "TA"){
			pg_query($db, "UPDATE applicant_is_a_ugrad SET program = '". $_POST['selectionmajor']."';");
		} else { 
			pg_query($db, "UPDATE applicant_is_a_grad SET advisor_name = '". $_POST['advisorname']."' WHERE sso = '".$sso."';");
			pg_query($db, "UPDATE applicant_is_a_grad SET grad_program = '". $_POST['masterphd']."' WHERE sso = '".$sso."';");
		}
	}

	if( $_POST['phoneNum'] && $_POST['gradDate'] && $_POST['currCourses']){
		pg_query($db, "UPDATE Applicant SET phone_number = '". $_POST['phoneNum']."',
			expected_grad_date = '". $_POST['gradDate']."';");
		pg_query($db, "INSERT INTO applicant_curr_taught_courses (sso, course) 
			VALUES ('".$sso."', '". $_POST['currCourses'] ."');");
	}

	if( $_POST['precourse'] && $_POST['courseLike'] && $_POST['otherPlace']){
		#need to fix semester taught
		pg_query($db, "INSERT INTO applicant_prev_taught_courses (sso, course_id, semester_taught) 
			VALUES ('".$sso."', '".$_POST['precourse']."', '". $_POST['precourse']."');");
		#need to fix grade received
		pg_query($db, "INSERT INTO applicant_wish_courses (sso, course_id, grade_received) 
			VALUES ('".$sso."', '". $_POST['courseLike'] ."', '". "A+" ."');");
		pg_query($db, "INSERT INTO applicant_other_workpalces (sso, workplace) 
			VALUES ('". $sso."', '". $_POST['otherPlace'] ."');");
	}

	if( $_POST['selectiontwo']){
		if($_POST['selectiontwo'] == "rm"){
			pg_query($db, "UPDATE Applicant SET gato_req_met = TRUE WHERE sso = '".$sso."';");
		} else pg_query($db, "UPDATE Applicant SET gato_req_met = FALSE WHERE sso = '".$sso."';");
	}

	if($_POST['speak_next_test_date'] && $_POST['selectionthree'] && $_POST['speakScore'] && $_POST['semesterLast']){
		pg_query($db, "DELETE FROM applicant_is_international WHERE sso = ". $sso.";");
		pg_query($db, "INSERT INTO applicant_is_international (sso) VALUES ('".$sso."');");
		if($_POST['selectionthree'] == "rm"){
			pg_query($db, "UPDATE applicant_is_international SET speak_test_score = '". $_POST['speakScore']."', 
				speak_last_test_date = '". $_POST['semesterLast'] ."', speak_req_met = TRUE WHERE sso = '".$sso."';");
		} else pg_query($db, "UPDATE applicant_is_international SET speak_req_met = FALSE,
		     speak_next_test_date = ".$_POST['timetoregister']." WHERE sso = '".$sso."');");
	}

	if( $_POST['selectionfour'] && $_POST['selectionfive']){
		if($_POST['selectionfour'] == "rm"){

		}

		if($_POST['selectionfive'] == "rm"){

		}
	}
?>
