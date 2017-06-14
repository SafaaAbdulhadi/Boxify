<?php
session_start();
$serviceFromForm = $_POST['ServiceMenu'];
$duration =$_POST['selectDuration'];
$day = $_POST['day'];
$month = date('M y');
$hour =$_POST['hour'];
$mins =$_POST['mins'];
$time = $hour.":".$mins;
$street_adress = $_POST['streeradress'];
$postcode = $_POST['postcode'];
$fullAddress = $street_adress." POSTCODE ".$postcode;
$howLong = $duration." Hours";
$Price = 0;
$newNumber = $_SESSION['numberToSent'];
$deliveryDate = $day." - ".$month;


if ($services = "Cleaner") {
    $Price = 15 * $duration;
}
elseif ($services = "Handyman")
{
	$Price = 10 * $duration;
}
else
{
	$Price = 20 * $duration;
}
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
					  <div class="col-md-12" style="float:left">
						  <h1 class="animated fadeInDown">You need a <?php echo $serviceFromForm ?><br>
                          For <?php echo $howLong ?><br>
                          On <?php echo $deliveryDate ?> At <?php echo $time ?><br>						
                          For this address <br>
                          <?php echo $fullAddress ?></h1>
                      </div>           
                        <div class="col-md-12" >
                        <form action="ProccessPayment.php" method="POST" name="userOrderForm" id="userOrderForm" onsubmit="return Validate();" form>
                        <input type="hidden" name="service_name" value="<?php echo $serviceFromForm; ?>">
                        <input type="hidden" name="duration" value="<?php echo $howLong ?>">
                        <input type="hidden" name="date" value="<?php echo $deliveryDate ?>">
                        <input type="hidden" name="time" value="<?php echo $time ?>">
                        <input type="hidden" name="address" value="<?php echo $fullAddress ?>">
                        <input type="hidden" name="price" value="<?php echo $Price ?>">
                        
						 <input name="submitButton" type="submit" id="submitButton" class="use-btn animated fadeInUp" value="Confirm" style="float:right">
                        </form>
                     <input name="EditButton" type="button" id="EditButton" class="use-btn animated fadeInUp" value="Edit" style="float:right" onclick="window.location='service.php'">
                    </div>
                      
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
							<li><a href="ClientHomePage.php">Home</a></li>
							<li><a href="service.php">Services</a></li>
							<li><a href="logout.php">Sign out</a></li>
							<li><a href="#download">Get in touch</a></li>
						</ul>
						</ul>
					</div>
				</div>
			</div>
		</footer>
		<div class="overlay overlay-boxify">
			<nav>
				<ul>
					<li><a href="ClientHomePage.php"><i class="fa fa-briefcase"></i>Home</a></li>
					<li><a href="service.php"><i class="fa fa-desktop"></i>Services</a></li>
				</ul>
				<ul>
					<li><a href="logout.php"><i class="fa fa-desktop"></i>Sign out</a></li>
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