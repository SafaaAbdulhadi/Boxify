<?php require_once('Connections/ProjectConnection.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "assignOrder")) {
  $updateSQL = sprintf("UPDATE order_table SET order_status=%s, provider_id=%s WHERE order_id=%s",
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['Service'], "int"),
                       GetSQLValueString($_POST['OrderID'], "int"));

  mysql_select_db($database_ProjectConnection, $ProjectConnection);
  $Result1 = mysql_query($updateSQL, $ProjectConnection) or die(mysql_error());

  $updateGoTo = "ConfirmAssign.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_order = "-1";
if (isset($_POST['order'])) {
  $colname_order = $_POST['order'];
}
mysql_select_db($database_ProjectConnection, $ProjectConnection);
$query_order = sprintf("SELECT * FROM order_table WHERE order_id = %s", GetSQLValueString($colname_order, "int"));
$order = mysql_query($query_order, $ProjectConnection) or die(mysql_error());
$row_order = mysql_fetch_assoc($order);
$totalRows_order = mysql_num_rows($order);

$service = $row_order['serviceName'];
if ( $service == "Cleaner")
{
	$service = 1;
}
if ( $service == "Handyman")
{
	$service = 2;
}
if ( $service == "Plumber")
{
	$service = 3;
}

mysql_select_db($database_ProjectConnection, $ProjectConnection);
$query_services = "SELECT * FROM service_providers WHERE service = '$service'";
$services = mysql_query($query_services, $ProjectConnection) or die(mysql_error());

$totalRows_services = mysql_num_rows($services);



?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<html lang="en" class="no-js">
<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Website</title>
		<meta name="description" content="A free HTML5/CSS3 template made exclusively for Codrops by Peter Finlan" />
		<meta name="keywords" content="html5 template, css3, one page, animations, agency, portfolio, web design" />
		<meta name="author" content="Peter Finlan" />
		<!-- Bootstrap -->
		<script src="js/modernizr.custom.js"></script>
<script src="jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="jQueryAssets/jquery-1.11.1.min.js" type="text/javascript"></script>
<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/jquery.fancybox.css" rel="stylesheet">
		<link href="css/flickity.css" rel="stylesheet" >
		<link href="css/animate.css" rel="stylesheet">
		<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Nunito:400,300,700' rel='stylesheet' type='text/css'>
		<link href="css/styles.css" rel="stylesheet">
		<link href="css/queries.css" rel="stylesheet">
		<style type="text/css">
		input {
	border-width: thin;
	border-style: solid;
}
        </style>
		<link href="jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
		<link href="jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
		<meta property="og:image" content=""/>
		<meta property="og:url" content=""/>
		<meta property="og:site_name" content=""/>
		<meta property="og:description" content=""/>
		<meta name="twitter:title" content="" />
		<meta name="twitter:image" content="" />
		<meta name="twitter:url" content="" />
		<meta name="twitter:card" content="" />
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
</head>
<body>
		<!--[if lt IE 7]>
		<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->
		<!-- open/close -->
		<header>
			<section class="hero">
				<!--<div class="texture-overlay"></div>-->
				<div class="container">
					<div class="row nav-wrapper">
						<div class="col-md-6 col-sm-6 col-xs-6 text-left">
							<a href="#"><img src="img/logo-white.png" alt="Boxify Logo"></a>
						</div>
						
					  <div class="col-md-6 col-sm-6 col-xs-6 text-right navicon">
					    <p>MENU</p><a id="trigger-overlay" class="nav_slide_button nav-toggle" href="#"><span></span></a>
					  </div>
					</div>
					<div class="row hero-content">
                    <br><br>
                   
                    <h2 class="animated fadeInDown" align="center"><u>Order No.</u> &nbsp; <?php echo $row_order['order_id']; ?></h2><br>
                    <h2 class="animated fadeInDown" align="center"><?php echo $row_order['serviceName']; ?> &nbsp; 
                    <?php echo $row_order['adress']; ?>
					  </h2>
                        <div align="center">
                        
                    <h3> Avialable Providers </h3>
                         
                    
                          <table width="553" border="1" class="animated fadeInLeftBig">
                            <tbody>
                              <tr>
                                <th width="218" align="center">First Name</th>
                                <th width="218" align="center">Last Name</th>
                                <th width="350" align="center">Location</th>
                               
                                <th width="95" align="center">Action</th>
                                
                              </tr>
                           <?php while ($row_services = mysql_fetch_assoc($services))
						   {
							   ?>
								  <tr>
                                  
                                <td><?php echo $row_services['firstName']; ?></td>
                                <td><?php echo $row_services['lastName']; ?></td>
                                <td><?php echo $row_services['address']; ?></td>
                                
                                
                                <td><form name="assignOrder" method="POST" action="<?php echo $editFormAction; ?>">
                                <input type="hidden" name="OrderID" value="<?php echo $row_order['order_id']; ?>">
                                <input type="hidden" name="Service" value="<?php echo $row_services['id']; ?>">
                                <input type="hidden" name="status" value="In Progress">
                                <input type="submit" value="Assign" align="middle">
                          
                          
                          
                          <input type="hidden" name="MM_update" value="assignOrder">
                                </form></td>
                          
                               
                               
                               
                              </tr>
							  <?php } ?>
                            </tbody>
                          </table>
                     
                        
                       
                        </div>
                        
                        <div class="col-md-12" >
                        <br>
                        <br><br><br>
						  <div class="col-md-12"  align="right">
                          <a href="NewOrdersAdmin.php" class="use-btn animated fadeInDown">Back to list</a>
                          <a href="AdminControlPanel.php" class="use-btn animated fadeInDown">Main Menu</a>
					</div>
					</div>
                        <input type="hidden" name="MM_insert" value="register">
                     
                      
				</div>
			</section>
		</header>
		
		
		

		
<footer>
  <div class="container">
				<div class="row">
					<div class="col-md-5">
						<h1 class="footer-logo">
						<img src="img/logo-blue.png" alt="Footer Logo Blue">
						</h1>
						<p>A© Boxify 2015.</p>
					</div>
					<div class="col-md-7">
						<ul class="footer-nav">
							<li><a href="AdminControlPanel.php">Home</a></li>
							
							<li><a href="logout.php">Sign Out</a></li>
							<li><a href="#download">Get in touch</a></li>
						</ul>
					</div>
				</div>
  </div>
</footer>
		<div class="overlay overlay-boxify">
			<nav>
				<ul>
					<li><a href="AdminControlPanel.php"><i class="fa fa-briefcase"></i>Home</a></li>
					
				<ul>
					<li><a href="logout.php"><i class="fa fa-desktop"></i>Sign Out</a></li>
					<li><a href="#download"><i class="fa fa-heart"></i>Get in touch</a></li>
				</ul>
			</nav>
		</div>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/min/toucheffects-min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/flickity.pkgd.min.js"></script>
<script src="js/jquery.fancybox.pack.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/retina.js"></script>
<script src="js/waypoints.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/min/scripts-min.js"></script>
		<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
		function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
		e=o.createElement(i);r=o.getElementsByTagName(i)[0];
		e.src='//www.google-analytics.com/analytics.js';
		r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
		ga('create','UA-XXXXX-X');ga('send','pageview');
        </script>
</body>
</html>
<?php 
mysql_free_result($services);

mysql_free_result($order);
?>
