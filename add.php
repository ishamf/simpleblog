<?php
if( isset( $_POST['post-title'] ) && isset( $_POST['post-content']) ){
	$title = $_POST['post-title'];
	$content = $_POST['post-content'];
}

?>

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
			<textarea name='post-content' style="width:640px; height : 300px; font-family : Arial"></textarea>
	<tr>
		<td>
			<input type=submit name='submit' value='add' />
</table>
</form>
