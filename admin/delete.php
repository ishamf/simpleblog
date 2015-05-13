<?php
include('../lib/SimpleBlog.php');
$id = intval($_GET['id']);
$blog = new SimpleBlog('localhost','root','','test');
$blog->deletePost( $id );

?>