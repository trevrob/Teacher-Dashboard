<?php 
session_start();
require_once('connection.php');

$query_student = "SELECT students.id, students.first_name, students.last_name 
		   		  FROM students
		   		  WHERE students.id={$_SESSION['student_id']}";
$student = fetch_record($query_student);

$query_exams = "SELECT exams.id, exams.subject, exams.grade, exams.status, exams.notes
				FROM exams
				WHERE exams.student_id = {$_SESSION['student_id']}";

$exams = fetch_all($query_exams);

 ?>

<html>
<head>
	<title>Student Info</title>
	<link rel="stylesheet" type="text/css" href="school_css.css">
</head>
<body>
	<div id='container'>
		<div class='head'>
			<h1><?php echo $student['first_name'] .' '. $student['last_name']; ?></h1>
		</div>
		<div class='body'>
			<h3>Exam Record:</h3>
			<?php 
					if(!empty($exams))
					{
					echo "<table id='exams_table'>";
					foreach($exams[0] as $key => $value)
					{
						$key = str_replace('_', ' ', $key);
						$key = ucwords($key);
						echo "<th>$key</th>";
					}
					echo "<th>Edit</th>
						  <th>Delete</th>";
					foreach($exams as $exam)
					{
						echo "<tr>
								  <td class='data'>{$exam['id']}</td>
								  <td class='data'>{$exam['subject']}</td>
								  <td class='data'>{$exam['grade']}</td>
								  <td class='data'>{$exam['status']}</td>
								  <td class='data_notes'>{$exam['notes']}</td>
								  <td><form action='process.php' method='post'>
									  	<input type='hidden' name='action_edit' value='edit_exam'>
									  	<input type='hidden' name='exam_id' value='{$exam['id']}'>
								  		<input type='submit' value='Edit'>
								  	   </form>
							  	  </td>
								  <td><form action='process.php' method='post'>
									  	<input type='hidden' name='action_delete' value='delete_exam'>
									  	<input type='hidden' name='exam_id' value='{$exam['id']}'>
								  		<input type='submit' value='Delete'>
								  	   </form>
							  	  </td>
							  </tr>";
					}
					echo "</table>";
				}
				else
				{
					echo "<p class='error'>No exam records to show</p>";
				}

				if(isset($_SESSION['error']['empty']))
					echo "<p class='error'>{$_SESSION['error']['empty']}</p>";
					unset($_SESSION['error']['empty']);
				 ?>


			<h3 id='add'>Add Record:</h3>
			<div id='add_record'>
				<form action='process.php' method='post'>
					<input type='hidden' name='action_exam' value='add_exam'>
					<p>Subject <input type='text' name='subject' placeholder='Subject'></p>
					<p>Grade 
						<select name='grade'>
							<?php 
								for ($i=100; $i > -1; $i--) 
								{ 
									echo "<option value='{$i}'>".$i."</option>";
								}
							?>
						</select>
					<p>Teacher's Notes: </p> 
					<p><textarea name='notes' placeholder='notes'></textarea></p>
					<input type='submit' value='Add Record'>
				</form>
			</div>
			<p><a href="process.php?home=1">Back to Homepage</a></p>
		</div>
	</div>
</body>
</html>