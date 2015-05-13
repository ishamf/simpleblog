<?php
include('lib/SimpleBlog.php');

$blog = new SimpleBlog('localhost','root','','test');

$resource = $blog->listPost();

while( $row = $resource->fetch_assoc() ){
	echo "
		<a href=\"view.php?id=$row[id]\"><h2>$row[title]</h2></a>
		$row[date_created]
		<p>$row[content]</p>
		<hr>
	";
}

?>