<?php require_once('Connections/ProjectConnection.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "serviceLogin.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "accept")) {
  $updateSQL = sprintf("UPDATE order_table SET order_status=%s WHERE order_id=%s",
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['order_id'], "int"));

  mysql_select_db($database_ProjectConnection, $ProjectConnection);
  $Result1 = mysql_query($updateSQL, $ProjectConnection) or die(mysql_error());

  $updateGoTo = "orderAccept.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "reject")) {
  $updateSQL = sprintf("UPDATE order_table SET order_status=%s, provider_id=%s WHERE order_id=%s",
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['pro'], "int"),
                       GetSQLValueString($_POST['order_id'], "int"));

  mysql_select_db($database_ProjectConnection, $ProjectConnection);
  $Result1 = mysql_query($updateSQL, $ProjectConnection) or die(mysql_error());

  $updateGoTo = "serviceControlPanel.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_POST['SelectedRow'])) {
  $colname_Recordset1 = $_POST['SelectedRow'];
}
mysql_select_db($database_ProjectConnection, $ProjectConnection);
$query_Recordset1 = sprintf("SELECT * FROM order_table WHERE order_id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $ProjectConnection) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
                      <div align="center">
                        <h2 class="animated fadeInLeftBig"><u>Order Details</u></h2> 
                    <table width="586" height="113" border="0">
                            <tbody>
                              <tr>
                                <td width="90" height="35"><label  class="animated fadeInLeft">Order No.</label></td>
                                <td width="486"><?php echo $row_Recordset1['order_id']; ?></td>
                              </tr>
                              <tr>
                                
                                <td height="35"><label  class="animated fadeInLeft" id="forList">Serivce Title </label></td>
                                <td><?php echo $row_Recordset1['serviceName']; ?></td>
                              </tr>
                              <tr>
                                <td height="35"><label  class="animated fadeInLeft">Service Duration? </label></td>
                                <td><p><?php echo $row_Recordset1['duration']; ?></p>
                                </td>
                              </tr>
                              <tr>
                               <td height="35"><label class="animated fadeInLeft" >Delivery Time? </label></td>
                              <td height="35"><?php echo $row_Recordset1['time']; ?></td >
                              </tr>
                                    <tr>
                                    <th height="35" class="animated fadeInLeft">Delivery Date?</th>
                                    <td height="35"><p><?php echo $row_Recordset1['date']; ?></p>
                                    </td>
                                    </tr>
                                    <tr>
                                    <th height="35" class="animated fadeInLeft">Total?</th>
                                    <td height="35" ><p><?php echo $row_Recordset1['price']." GP"; ?></p>
                                    </td>
                                    </tr>
                                    <tr>
                                    <th height="35" class="animated fadeInLeft">Location?</th>
                                    <td height="35"><p><?php echo $row_Recordset1['adress']; ?></p>
                                    </td>
                                    </tr>
                                    <tr>
                                    <th height="35" class="animated fadeInLeft">Date Made?</th>
                                    <td height="35"><p><?php echo $row_Recordset1['date_made']; ?></p>
                                    </td>
                                    </tr>
                                    
                            </tbody>
                        </table>
                         <form action="<?php echo $editFormAction; ?>" name="reject" method="POST" >
                        <input type="hidden" name="order_id" value="<?php echo $row_Recordset1['order_id']; ?>" >
                        <input type="hidden" name="pro" value="0">
                        <input type="hidden" name="status" value="New">
                        <input type="submit" class="use-btn animated fadeInDown" value="Reject Order" style="float:right">
                        <input type="hidden" name="MM_update" value="accept">
                        <input type="hidden" name="MM_update" value="reject">
                        </form>
                        </div>
                        <form action="<?php echo $editFormAction; ?>" name="accept" method="POST" >
                        <input type="hidden" name="order_id" value="<?php echo $row_Recordset1['order_id']; ?>" >
                        <input type="hidden" name="status" value="Completed">
                        <input type="submit" class="use-btn animated fadeInDown" value="Accept Order" style="float:right">
                        <input type="hidden" name="MM_update" value="accept">
                        </form>
                        
                     
                        <div class="col-md-12"  align="right">
			
                          <a href="serviceControlPanel.php" class="use-btn animated fadeInDown" style="float:left">Main Menu</a>
					</div>
                       
                      </form>
                      
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
							<li><a href="#about">Services</a></li>
							<li><a href="#features">Log in</a></li>
							<li><a href="#screenshots">Sign up</a></li>
							<li><a href="#download">Get in touch</a></li>
						</ul>
					</div>
				</div>
  </div>
</footer>
		<div class="overlay overlay-boxify">
			<nav>
				<ul>
					<li><a href="#about"><i class="fa fa-briefcase"></i>Services</a></li>
					<li><a href="#features"><i class="fa fa-desktop"></i>Login</a></li>
				</ul>
				<ul>
					<li><a href="#screenshots"><i class="fa fa-desktop"></i>Sign up</a></li>
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
mysql_free_result($Recordset1);
?>
