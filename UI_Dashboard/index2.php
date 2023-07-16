<?php 
session_start();
error_reporting(0);
include('includes/config.php');


if (isset($_POST['submit'])){



    $name="haha";
    $img=hash('ripemd160',date("Y-m-d H:i:s"));
    $path="C:\\Users\\LENOVO\\Desktop\\stage\\unknown\\$img".".jpg";
    move_uploaded_file($_FILES['fl']['tmp_name'],$path);
$sql="INSERT INTO  image_insert(name,imagename) VALUES(:name,:path)";
$query = $dbh->prepare($sql);
$query->bindParam(':name',$name,PDO::PARAM_STR);
$query->bindParam(':path',$path,PDO::PARAM_STR);
$query->execute();
//move_uploaded_file($_FILES['image']['tmp_name'],"picture/$img");
        /*if(mysql_query($sql)){
            move_uploaded_file($_FILES['image']['tmp_name'],"picture/$img");
    }
*/
    echo $path;
    

}




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="fl">
<input type="submit" name="submit">
</form>
</body>
</html>
