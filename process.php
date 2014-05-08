<?php 
session_start();
require_once('connection.php');

///////// add student function /////////

function add_student($post)
{
	foreach($post as $name => $value)
	{
		if(empty($value))
		{
			$_SESSION['error']['blank'] = "Sorry, first or last name cannot be blank";
		}
		elseif (is_numeric($post['first_name']) || is_numeric($post['last_name']))
		{
			$_SESSION['error']['name'] = "Name cannot contain numbers";
		}
	}

	if(!isset($_SESSION['error']))
	{
		$_SESSION['success'] = "student added successfully";

		$query = "INSERT INTO students (first_name, last_name, created_at, updated_at)
				  VALUES ('{$post['first_name']}', '{$post['last_name']}', NOW(), NOW())";
		run_mysql_query($query);
		
	}

	header('location: index.php');
	exit;
	
}
//////// student select on index page /////////

function student_select($post)
{
	$query = "SELECT id from students
			  WHERE id={$post['student_select']}";
	$row = fetch_record($query);

	$_SESSION['student_id'] = $row['id'];

	header('location: student.php');
	exit;
}

///////// add exam record to student ////////

function add_exam($post)
{
	if(empty($post['subject']))
	{
		$_SESSION['error']['empty'] = "You must enter a subject";
	}
	else
	{
		if($post['grade'] >= 60)
		{
			$status = 'passed';
		}
		else
		{
			$status = 'failed';
		}

		$query = "INSERT INTO exams (grade, status, notes, created_at, updated_at, subject, student_id)
				  VALUES ({$post['grade']}, '{$status}', '{$post['notes']}', NOW(), NOW(), '{$post['subject']}', {$_SESSION['student_id']})";

		run_mysql_query($query);
	}

	header('location: student.php');
	exit;

}

///////// delete exam from student record /////////

function delete($post)
{
	$query = "DELETE FROM exams
			  WHERE id={$post['exam_id']}";

	
	run_mysql_query($query);
	header('location: student.php');
	exit;
}

///////// edit exam from student record ///////

function edit($post)
{
	$query = "SELECT exams.id
			  FROM exams
			  WHERE id={$post['exam_id']}";

	fetch_record($query);

	$_SESSION['exam_id'] = $post['exam_id'];

	header('location: edit_subject.php');
	exit;
}

/////// update exam for student /////

function update($post)
{
	if(isset($_SESSION['exam_id']))
	{
		if(empty($post['subject']))
		{
			$_SESSION['error']['subject'] =  "Subject cannot be blank";
			header('location: edit_subject.php');
			exit;

		}
		else
		{
			if($post['grade'] >= 60)
			{
				$status = 'passed';
			}
			else
			{
				$status = 'failed';
			}
			$query = "UPDATE exams
					  SET id={$_SESSION['exam_id']}, subject='{$post['subject']}', grade={$post['grade']}, status='{$status}',  notes = '{$post['notes']}'
					  WHERE id = {$_SESSION['exam_id']}";

			run_mysql_query($query);
			header('location: student.php');
			exit;
		}

	}
	
}

/////// back button on update page ///////

function back($post)
{
	header('location: student.php');
	exit;
}

//////// home link on bottom of student page ////////
if(isset($_GET['home']))
{
	header('location: index.php');
	exit;
}

///////// CALLING FUNCTIONS /////////

//////// add student ////////

if(isset($_POST['action_add']) && $_POST['action_add'] == 'add_student')
{
	add_student($_POST);
}

///////// select student on index page ////////

if(isset($_POST['action']) && $_POST['action'] == 'student')
{
	student_select($_POST);
}

/////// add exam to student record //////

if(isset($_POST['action_exam']) && $_POST['action_exam'] == 'add_exam' )
{
	add_exam($_POST);
}

/////// delete exam from student ////////
if(isset($_POST['action_delete']) && $_POST['action_delete'] == 'delete_exam')
{
	delete($_POST);
}

////// edit exam for student //////
if(isset($_POST['action_edit']) && $_POST['action_edit'] = 'edit_exam')
{
	edit($_POST);
}

/////// update exam info for student ///////
if(isset($_POST['action_update']) && $_POST['action_update'] == 'update_exam')
{
	update($_POST);
}

////// back button on update page ///////
if(isset($_POST['action_back']) && $_POST['action_back'] == 'go_back')
{
	back($_POST);
}

 ?>