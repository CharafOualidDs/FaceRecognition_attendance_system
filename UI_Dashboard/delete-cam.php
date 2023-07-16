<?php
include 'includes/config.php' ;

$sql="delete from camera where id=:id";
$query=$dbh->prepare($sql);
$query->execute(["id"=>$_GET["id"]]);
$query->closeCursor();
header("Location:consulter-cam.php");



?>