<?php 
session_start();
error_reporting(0);
include 'includes/config.php' ;

if($_SESSION['alogin']=="")
    {
    header("Location: index.php");
    }
    else{
if(isset($_POST['submit'])){

    $email=$_POST['email'];
    $password=md5($_POST['password']);

$sql="insert into login(email,password) values(:email,:password)";
$query=$dbh->prepare($sql);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->execute();


$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="admin cree avec sucees!";
}
else
{
$error="Quelque chose a mal tourné. Veuillez réessayer";
}






}



?>
<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" href="css/admin.css"> 
    <title>creation admin</title> 
</head> 
<body> 
 <form action="" method="POST">
    <div class="wrapper"> 
        <div class="logo"> 
            <img src="images/admin.png" alt=""> 
        </div> 
        <div class="text-center mt-4 name"> 
            admin 
        </div> 
        <?php if($msg){?>
<div class="alert alert-success left-icon-alert" role="alert">
 <strong>admin cree avec succes! </strong><?php }?>
        <form class="p-3 mt-3" action="results.php" method="post"> 
            <div class="form-field d-flex align-items-center"> 
                <span class="far fa-user"></span> 
                <input type="text" name="email" id="email" placeholder="email" autocomplete="off" required> 
            </div> 
            <div class="form-field d-flex align-items-center"> 
                <span class="fas fa-key"></span> 
                <input type="password" name="password" id="pwd" placeholder="Mot de passe" > 
            </div> 
            <button class="btn mt-3" type="submit" name="submit">Ajouter admin</button>    
    </div> 
    <br>
    <a href="index.php">retour a la page d'acceuil</a>
 

 
 
    </form> 
</body> 
</html>
<?php }?>