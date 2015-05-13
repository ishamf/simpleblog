<?php
include('lib/SimpleBlog.php');

$id = intval( $_GET['id'] );

$blog = new SimpleBlog('localhost','root','','test');
$res = $blog->getPostById( $id );

if( $res->num_rows == 0 ){
	header('Location : index.php');
}

$row = $res -> fetch_assoc();

echo
"
	<a href=\"view.php?id=$row[id]\"><h2>$row[title]</h2></a>
	$row[date_created]
	<p>$row[content]</p>
	<hr>
	Comment : <br>
";

$res = $blog -> getCommentsByPostId( $id );

if( $res -> num_rows == 0 ){
	echo "No Comment so far";
}
else {
	
	while( $row = $res->fetch_assoc() ){
		echo "<HR>$row[name] $row[email] $row[date_created]<BR> $row[comment]";
	}
}

?>
<HR>