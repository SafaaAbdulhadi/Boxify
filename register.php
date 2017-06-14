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

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="register.php";
  $loginUsername = $_POST['userNamefield'];
  $LoginRS__query = sprintf("SELECT username FROM customer WHERE username=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_ProjectConnection, $ProjectConnection);
  $LoginRS=mysql_query($LoginRS__query, $ProjectConnection) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "register")) {
  $insertSQL = sprintf("INSERT INTO customer (firstName, lastName, email, username, password, phoneNo, personalCode) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['firstNameField'], "text"),
                       GetSQLValueString($_POST['lastnameField'], "text"),
                       GetSQLValueString($_POST['emailField'], "text"),
                       GetSQLValueString($_POST['userNamefield'], "text"),
                       GetSQLValueString($_POST['passwordfield'], "text"),
                       GetSQLValueString($_POST['phoneField'], "text"),
                       GetSQLValueString($_POST['code'], "text"));

  mysql_select_db($database_ProjectConnection, $ProjectConnection);
  $Result1 = mysql_query($insertSQL, $ProjectConnection) or die(mysql_error());

  $insertGoTo = "registerConfirmation.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_ProjectConnection, $ProjectConnection);
$query_userRegister = "SELECT * FROM customer";
$userRegister = mysql_query($query_userRegister, $ProjectConnection) or die(mysql_error());
$row_userRegister = mysql_fetch_assoc($userRegister);
$totalRows_userRegister = mysql_num_rows($userRegister);
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
					  <form method="POST" action="<?php echo $editFormAction; ?>" name="register" id="register">
                        <div align="center">
                          <p>&nbsp;</p>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p>
                          
                          <table width="586" height="185" border="0">
                            <tbody>
                              <tr>
                                <td width="133" height="35"><label for="firstName" class="animated fadeInLeft">First Name</label></td>
                                <td width="443"><input name="firstNameField" type="text" class="animated fadeInRight" id="firstName" size="35"></td>
                              </tr>
                              <tr>
                                
                                <td height="35"><label for="lastName" class="animated fadeInLeft">Last Name</label></td>
                                <td><input name="lastnameField" type="text" class="animated fadeInRight" id="lastName" size="35"></td>
                              </tr>
                              <tr>
                                
                                <td height="35"><label for="email" class="animated fadeInLeft">Email</label></td>
                                <td><input name="emailField" type="email" class="animated fadeInRight" id="email" size="50"></td>
                             
                              </tr>
                              <tr>
                                
                                <td height="35"><label for="phone" class="animated fadeInLeft">Phone No.</label></td>
                                <td><input name="phoneField" type="text" class="animated fadeInRight" id="phone"></td>
                             
                              </tr>
                              <tr>
                                
                                <td height="35"><label for="userName" class="animated fadeInLeft">User Name</label></td>
                                <td><input name="userNamefield" type="text" class="animated fadeInRight" id="userName" size="28"></td>
                             
                              </tr>
                              <tr>
                                
                                <td height="35"><label for="password" class="animated fadeInLeft">Password</label></td>
                                <td><input name="passwordfield" type="password" class="animated fadeInRight" id="password" size="35"></td>
                             
                              </tr>
                              <tr>
                                
                                <td height="35"><label for="password" class="animated fadeInLeft">Personal Code</label></td>
                                <td><input name="code" type="text" class="animated fadeInRight" id="password" size="35"></td>
                             
                              </tr>
                            </tbody>
                          </table>
                          <p>&nbsp;</p>
                      </div>
                        
                        
                        
                        <div class="col-md-12">
							<input name="submitButton" type="submit" id="submitButton" class="use-btn animated fadeInUp">
					</div>
                        <input type="hidden" name="MM_insert" value="register">
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
mysql_free_result($userRegister);
?>
