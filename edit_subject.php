<?php 
session_start();
require_once('connection.php');
$query_student = "SELECT students.first_name, students.last_name
				  FROM students
				  WHERE id={$_SESSION['student_id']}";
$student = fetch_record($query_student);

if(isset($_SESSION['exam_id']))
{
$query_exam = "SELECT exams.subject, exams.grade, exams.notes
			   FROM exams
			   WHERE id={$_SESSION['exam_id']}";

$exam = fetch_record($query_exam);
}
 ?>

<html>
<head>
	<title>Edit Subject</title>
	<link rel="stylesheet" type="text/css" href="school_css.css">
</head>
<body>
	<div id='container'>
		<div class='head'>
			<h1><?php echo "{$student['first_name']} {$student['last_name']}"; ?></h1>
		</div>
		<div class='body'>
			<?php 
			if(isset($_SESSION['exam_id']))
			{
				if(isset($_SESSION['error']['subject']))
				{
					echo "<p class='error'> {$_SESSION['error']['subject']}</p>";
					unset($_SESSION['error']['subject']);
				}
			?>
			<h2>Edit Record</h2>
				<form action='process.php' method='post'>
					<input type='hidden' name='action_update' value='update_exam'>	
					<p><b>Subject: </b><input type='text' name='subject' placeholder='<?= $exam['subject'] ?>'></p>

					<p><b>Grade: </b>
						<select name='grade'>
							<option value='<?= $exam['grade'] ?>'><?= $exam['grade'] ?></option>
							<?php 
							for ($i=100; $i > 0; $i--) 
							{ 
								echo "<option value='{$i}'>".$i."</option>";
							}
							 ?>
						</select>
					</p>
					<p><b>Teacher's Notes: </b></p><p><textarea name='notes'><?= $exam['notes'] ?></textarea></p>
					<input type='submit' value='Update'>
				</form>
				<form action='process.php' method='post'>
					<input type='hidden' name='action_back' value='go_back'>	
					<input type='submit' value='Go Back'>
				</form>
			<?php 
			}
			else
			{
				echo "<p class='error'> You must select an exam to edit </p>";
			}
			 ?>
			 <br>
			 <br>
			 <br>
			 <br>
			 <br>
			<br>
			 <p><a href="process.php?home=1">Back to Homepage</a></p>
		</div>
	 </div>
</body>
</html>