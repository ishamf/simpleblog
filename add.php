<?php
include('lib/SimpleBlog.php');


if( isset( $_POST['post-title'] ) && isset( $_POST['post-content']) ){
	$blog = new SimpleBlog( 'localhost','root','','test');
	
	$title = $_POST['post-title'];
	$content = $_POST['post-content'];
	
	$blog->addPost( $title, $content );
	
}

?>

<!doctype HTML>
<html lang=en>
<head>
	<title>SimpleBlog - Add Post </title>
	<link rel="stylesheet" href="css/smoothness/jquery-ui.css">
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui.js"></script>
</head>

<body>
	<form action='add.php' method=POST>
	<table>
		<tr>
			<td>
				<h1>Add Post</h1>
		<tr>
			<td>
				<input name='post-title' style="width:640px; font-family : Arial" autofocus />
		<tr>
			<td>
				<input name='post-date' id=datepicker type=text />
		<tr>
			<td>
				<textarea name='post-content' style="width:640px; height : 300px; font-family : Arial"></textarea>
		<tr>
			<td>
				<input type=submit name='submit' value='add' />
	</table>

	<script>
	$(function() {
		$( "#datepicker" ).datepicker({
			minDate : new Date()
		});
	});
	</script>

	</form>
</body>
</html>