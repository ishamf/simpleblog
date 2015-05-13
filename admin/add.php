<?php
include('../lib/SimpleBlog.php');

if( isset( $_POST['post-title'] ) && isset( $_POST['post-content']) ){
	$blog = new SimpleBlog( 'localhost','root','','test');
	
	$title = $_POST['post-title'];
	$content = $_POST['post-content'];
	$date = $_POST['post-date'];
	
	$blog->addPost( $title, $content, $date );

	header('Location: list.php');
} else {
	$post_content = ''; $post_title = ''; $post_date = '';

	$buttonText = "add new post";	
	include('editor.php');
}


?>

