<?php
session_start();
error_reporting(0);
include('includes/config.php');
if($_SESSION['alogin']=="")
    {
    header("Location: index.php");
    }
    else{

$id=intval($_GET['id']);

if(isset($_POST['submit']))
{



    $nom=$_POST['fullanme'];
    $prenom=$_POST['prenom'];
    $cin=$_POST['cin'];
    $email=$_POST['email'];
    $tel=$_POST['tel'];
    $img=hash('ripemd160',date("Y-m-d H:i:s"));
    #$dir="C:\\xamp\\htdocs\\charaf2\\knowns\\";
    $source = "knowns/$img".".jpg";
    $path="C:\\xampp\\htdocs\\charaf2\\knowns\\$img".".jpg";
    echo "first ".strlen($_FILES['fl']['tmp_name']);
    move_uploaded_file($_FILES['fl']['tmp_name'],$path);
    
    
    
    
    $sql="update tblemployer set nom=:fullanme,prenom=:prenom,cin=:cin,email=:email,tel=:tel,imagename=:path,source=:source where id=$id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':fullanme',$nom,PDO::PARAM_STR);
    $query->bindParam(':prenom',$prenom,PDO::PARAM_STR);
    $query->bindParam(':cin',$cin,PDO::PARAM_STR);
    $query->bindParam(':email',$email,PDO::PARAM_STR);
    $query->bindParam(':tel',$tel,PDO::PARAM_STR);
    $query->bindParam(':path',$path,PDO::PARAM_STR);
    $query->bindParam(':source',$source,PDO::PARAM_STR);

    $query->execute();



$msg="Les données ont été mises à jour avec succès";
}


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Mettre à jour un employer</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
        <link rel="stylesheet" href="css/select2/select2.min.css" >
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
    </head>
    <body class="top-navbar-fixed">
        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->
  <?php include('includes/topbar.php');?>
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">

                    <!-- ========== LEFT SIDEBAR ========== -->
                   <?php include('includes/leftbar.php');?>
                    <!-- /.left-sidebar -->

                    <div class="main-page">

                     <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">Mettre à jour un étudiant</h2>

                                </div>

                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Accueil</a></li>

                                        <li class="active">Mettre à jour un employer</li>
                                    </ul>
                                </div>

                            </div>
                            <!-- /.row -->
                        </div>
                        <div class="container-fluid">

                        <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                  <h5>Remplissez les informations de l'employer</h5>
                                                </div>
                                            </div>
                                            <div class="panel-body">
<?php if($msg){?>
<div class="alert alert-success left-icon-alert" role="alert">
 <strong>Bien fait! </strong><?php echo htmlentities($msg); ?>
 </div><?php }
else if($error){?>
    <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Erreur! </strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                                <form class="form-horizontal" method="post" enctype="multipart/form-data">
<?php

$sql = "SELECT * from tblemployer where id=:id";
$query = $dbh->prepare($sql);
$query->bindParam(':id',$id,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  ?>


<div class="form-group">
<label for="default" class="col-sm-2 control-label">Nom </label>
<div class="col-sm-10">
<input type="text" name="fullanme" class="form-control" id="fullanme" value="<?php echo htmlentities($result->nom)?>" required="required" autocomplete="off">
</div>
</div>
<div class="form-group">
<label for="default" class="col-sm-2 control-label">Prenom</label>
<div class="col-sm-10">
<input type="text" name="prenom" class="form-control" id="prenom" value="<?php echo htmlentities($result->prenom)?>" required="required" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">CIN</label>
<div class="col-sm-10">
<?php if ($result->nom=="unknown"){ ?>
    <input type="text" name="cin" class="form-control" id="cin" value="<?php echo htmlentities($result->cin)?>"  required="required" autocomplete="off" >
<?php }else{?>
    <input type="text" name="cin" class="form-control" id="cin" value="<?php echo htmlentities($result->cin)?>"  required="required" autocomplete="off" readonly>

<?php }?>

</div>
</div>
<?php }} ?>



<div class="form-group">
<label for="default" class="col-sm-2 control-label">Email</label>
<div class="col-sm-10">
<input type="text" name="email" class="form-control" id="email" value="<?php echo htmlentities($result->email)?>" required="required" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">N telephone</label>
<div class="col-sm-10">
<input type="text" name="tel" class="form-control" id="tel" value="<?php echo htmlentities($result->tel)?>" required="required" autocomplete="off">
</div>
</div>

<?php $ima=$result->source;?>
<div class="form-group">
<label for="default" class="col-sm-2 control-label">Image</label>
<div class="col-sm-10">
<img style="max-height:200px;max-width:200px;" src="<?php echo $ima;?>" alt="" srcset="">
<input type="file" style="width:150px;"  name="fl" class="form-control w" id="file" >
</div>
</div>


                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit" name="submit" class="btn btn-primary">Mettre à jour</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-md-12 -->
                                </div>
                    </div>
                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- /.main-wrapper -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>
        <script src="js/prism/prism.js"></script>
        <script src="js/select2/select2.min.js"></script>
        <script src="js/main.js"></script>
        <script>
            $(function($) {
                $(".js-states").select2();
                $(".js-states-limit").select2({
                    maximumSelectionLength: 2
                });
                $(".js-states-hide").select2({
                    minimumResultsForSearch: Infinity
                });
            });
        </script>
    </body>
</html>
<?PHP } ?>
