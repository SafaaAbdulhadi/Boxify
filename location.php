<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
<a href="" id="get-location">Get My Location</a>
<div id="Here">
</div>


<script>

var c = function(pos) {
		var lat = pos.coords.latitude,
		    lng = pos.coords.longitude,
			coords = lat + ',' + lng;
		window.location.href = "test.php?w1=" + lat + "&w2=" + lng;
	}
	
	
document.getElementById('get-location').onclick = function(){
	navigator.geolocation.getCurrentPosition(c);
	return false;
}
</script>
</body>
</html>
