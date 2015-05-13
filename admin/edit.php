<?php
include('../lib/SimpleBlog.php');

$blog = new SimpleBlog('localhost','root','','test');

function bailOut(){
	header('Location: list.php');
}

if( !isset($_GET['id']) ) bailOut();

$post_id = intval( $_GET['id'] );
$resource = $blog->getPostById( $post_id );
if( $resource->num_rows == 0 ) bailOut();

$post_content = ''; $post_title = ''; $post_date = '';

if( isset($_POST['post-title']) && isset($_POST['post-content']) && isset( $_POST['post-date']) )
{
	$blog->updatePost( $post_id, $_POST['post-title'], $_POST['post-content'], $_POST['post-date'] );
	
	$post_content = addslashes( $_POST['post-content'] );
	$post_title = addslashes( $_POST['post-title'] );
	$post_date = addslashes( $_POST['post-date'] );
	
	bailOut();
}
else {
	$data = $resource->fetch_assoc();

	$post_content = $data['content'];
	$post_title = $data['title'];
	$post_date = $data['date_created'];

	$buttonText = "Save Changes";
	include('editor.php');
}


?>
