<?php 
session_start();
require('connection.php');

$query_student = "SELECT students.id, students.first_name, students.last_name FROM students";
$students = fetch_all($query_student);
 ?>

<html>
<head>
	<title>Dashboard</title>
	<link rel="stylesheet" type="text/css" href="school_css.css">
</head>
<body>
	<div id='container'>
		<div class='head'>
			<h1>Welcome, Teacher!</h1>
		</div>
		<div class='body'>
			<form action='process.php' method='post'>
				<input type='hidden' name='action' value='student'>
				<h2>Select Student
					<p><select name='student_select'>
						<?php
						foreach($students as $student)
						{
							echo "<option value='{$student['id']}''>{$student['first_name']}  {$student['last_name']}</option>";
						}
						?>
						
					</select>
					<input id='show' type='submit' value='Show Exam Record'>
				</p>
			</form>
			<?php 

				echo "<table>";
				foreach($students[0] as $key => $value)
				{
					$key = str_replace('_', ' ', $key);
					$key = ucwords($key);
					echo "<th>$key</th>";
				}
				foreach($students as $student)
				{
					echo "<tr><td>{$student['id']}</td>
						  <td>{$student['first_name']}</td>
						  <td>{$student['last_name']}</td></tr>";
				}
				echo "</table>";
			 ?>
			 <hr>
			 <h3>Add Student</h3>

			<form action='process.php' method='post'>
				<input type='hidden' name='action_add' value='add_student'>
				<p>First Name: <input type='text' name='first_name' placeholder='First Name'></p>
				<p>Last Name:<input type='text' name='last_name' placeholder='Last Name'></p>
				<input type='submit' value='Add Student'>
			</form>
				<?php 
				if(isset($_SESSION['error']))
				{
					foreach($_SESSION['error'] as $message)
					{
					echo "<p class ='error'>{$message}</p>";
					unset($_SESSION['error']);
					}
				}
				elseif(isset($_SESSION['success']))
				{
					echo "<div> <p class='success'>{$_SESSION['success']}</p></div>";
					unset($_SESSION['success']);
				}
				 ?>
		</div>
	</div>
</body>
</html>