<?php
session_start();
error_reporting(0);
include('includes/config.php');
if($_SESSION['alogin']!=''){
//$_SESSION['alogin']='';
header('Location: dashboard.php');
}
if(isset($_POST['login']))
{
$uname=$_POST['username'];
$password=$_POST['password'];

$sql ="SELECT email,password FROM login WHERE email=:uname and password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':uname', $uname, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
$_SESSION['alogin']=$_POST['username'];
echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
} else{
    

    $error="Email ou mot de pass invalide, Veuillez réessayer";

}


}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SGRE</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>

        <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="mdb/css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="mdb/css/mdb.min.css" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="mdb/css/style.css" rel="stylesheet">
    </head>
    <body class="">
    <!--Navbar -->
<!--/.Navbar -->
<div class="container-fluid text-center">

  <!--Card-->
  <div class="card card-cascade wider reverse my-4 pb-5" id="card">

    <!--Card content-->
    <div class="card-body card-body-cascade text-center wow fadeIn" data-wow-delay="0.2s">
  <section class="p-md-3 mx-md-5 text-center text-lg-left">
        <div class="main-wrapper">

            <div class="">
                <div class="row">
                    <div class="col-lg-6 visible-lg-block">

<section class="section">
                            <div class="row mt-40">
                                <div class="col-md-12 col-md-offset-1 pt-50">

                                    <div class="row mt-30 ">
                                        <div class="col-md-11">
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <div class="panel-title text-center">
                                                    <div>
                                                      <i class="fa fa-users fa-4x p-4 blue-text"></i>
                                                    </div>
                                                    <h4>Espace employer</h4>
                                                    </div>
                                                </div>
                                    <form action="profil-login.php" method="post">
                                                <div class="panel-body p-20">                                                
                                                        <div class="form-group">         
                                                            <div class="col-sm-12">
                                                               <a href="profil-login.php" class="btn btn-primary col-sm-12 col-md-12">cliquez ici</a>
                                                            </div>

                                   </form>




                                                </div>
                                            </div>
                                            <!-- /.panel -->

                                        </div>
                                        <!-- /.col-md-11 -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.col-md-12 -->
                            </div>
                            <!-- /.row -->
                        </section>
                    </div>
                    <div class="col-lg-6">
                        <section class="section">
                            <div class="row mt-40">
                                <div class="col-md-12 col-md-offset-1 pt-50">

                                    <div class="row mt-30 ">
                                        <div class="col-md-11">
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <div class="panel-title text-center">
                                                    <div>
                                                      <i class="fas fa-user-shield fa-4x p-4 green-text"></i>
                                                    </div>
                                                        <h4>Administrateur</h4>
                                                    </div>
                                                </div>
                                                <div class="panel-body p-20">

                                    
                                                <?php  if($error){?>
                                                <div class="alert alert-danger left-icon-alert" role="alert">
                                                <strong>Erreur! </strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                                    <form class="form-horizontal" method="post">
                                                    	<div class="form-group">
                                                    		<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                                                    		<div class="col-sm-10">
                                                    			<input type="text" name="username" class="form-control" id="inputEmail3" placeholder="Nom d'utilisateur" autocomplete="off" required>
                                                    		</div>
                                                    	</div>
                                                    	<div class="form-group">
                                                    		<label for="inputPassword3" class="col-sm-2 control-label">Code</label>
                                                    		<div class="col-sm-10">
                                                    			<input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Mot de passe" required>
                                                    		</div>
                                                    	</div>

                                                        <div class="form-group mt-20">
                                                    		<div class="col-sm-offset-2 col-sm-10">

                                                    			<button type="submit" name="login" class="btn btn-success pull-right">Se connecter <span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
                                                    		</div>
                                                    	</div>
                                                    </form>




                                                </div>
                                            </div>
                                            <!-- /.panel -->

                                        </div>
                                        <!-- /.col-md-11 -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.col-md-12 -->
                            </div>
                            <!-- /.row -->
                        </section>

                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /. -->
            <p class="text-muted text-center"><small id="copy">Copyright © CHARAF OUALID</small></p>
        </div>
        <!-- /.main-wrapper -->
</section>
        </div>
        </div>
        </div>


        <!-- ========== COMMON JS FILES ========== -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/jquery-ui/jquery-ui.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- JQuery -->
  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="js/mdb.min.js"></script>

        <!-- ========== PAGE JS FILES ========== -->

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
        <script>
            $(function(){

            });
        </script>

        <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->
    </body>
</html>