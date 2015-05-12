<?php
if( isset( $_POST['post-title'] ) && isset( $_POST['post-content']) ){
	$title = $_POST['post-title'];
	$content = $_POST['post-content'];
}

?>

<form action='add.php' method=POST>
	<input name='post-title' />
	<textarea name='post-content'>
	</textarea>
	<input type=submit name='submit' value='add' />
</form>
