<?php
include('../lib/SimpleBlog.php');

$blog = new SimpleBlog('localhost','root','','test');

$resource = $blog->listPost();

while( $row = $resource->fetch_assoc() ){
	echo "
		<h2>$row[title]</h2>
		$row[date_created]
		<a href=\"edit.php?id=$row[id]\">Edit</a>
		<a href=\"delete.php?id=$row[id]\" onclick=\"return confirm('Are you Sure ?');\">Delete</a>
		<p>
		$row[content]
		</p>
		<hr>
	";
}
?>