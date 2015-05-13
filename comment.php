<?php
include('lib/SimpleBlog.php');

if( !isset( $_GET['pid'] ) && !isset( $_GET['action'] ) ) header('Location : index.php');

$postId = intval( $_GET['pid'] );

if( 
	$_GET['action'] == 'add' && 
	!empty($_POST['name']) &&
	!empty($_POST['email']) &&
	!empty($_POST['comment'])
){
	$name = $_POST['name'];
	$email = $_POST['email'];
	$comment = $_POST['comment'];
	
	$blog = new SimpleBlog( 'localhost', 'root', '', 'test' );
	
	$blog -> addComment( $postId, $name, $email, $comment );
}


?>