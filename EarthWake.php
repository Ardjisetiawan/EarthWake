<?php 
include ("geodatasource.php");
//1. Inputing earthquake time to PHP variable ($waktu_gempa)
$url = 'http://data.bmkg.go.id/autogempa.xml';
$xml = simplexml_load_file($url);
$waktu_gempa = $xml->gempa->Jam;

//2. Converting $waktu_gempa (string) to (time)
$waktu_gempa = str_replace(" WIB", "", $waktu_gempa);
$waktu_gempa = strtotime($waktu_gempa);

//3. Getting current time and convert to the same form as $waktu_gempa (time)
$current = strtotime((string)date("h:i:sa")) + 21600;

//4. IsEarthQuake? True if time diff == +/- 30
$diff = $current - $waktu_gempa;
print_r($diff);
$IsEarthQuake = False;
if (($diff >= -30) and ($diff <= 30)){
	$IsEarthQuake = True;
	print_r("Terjadi gempa! ");
	echo '<br/>';
}

//5. IsLethal? True if magnitude >= 5.0
$IsLethal = False;
$magnitude = 0;
if ($IsEarthQuake == True) {
	$magnitude = $xml -> gempa ->Magnitude;
	$magnitude = (float) $magnitude;
	if ($magnitude > 5.0) {
		$IsLethal = True;
		print_r("Gempa Berbahaya!");
		echo '<br/>';
	} else {
		print_r("Gempa Lemah");
		echo '<br/>';
	}
}

//6. Earthquake Radius Calculator
$radius = 0;
if ($IsLethal = True) {
	$radius = exp($magnitude/1.01 - 0.13);
}

//7. User Location
//7.1 Method 1: Use ip-api.io 
//This method is disabled because of ip-api.io usage limit. Saved in case needed for future use (more accurate value than method 2)
/*
	$data = json_decode(file_get_contents('http://ip-api.io/api/json'));
	$lat = $data -> latitude;
	$long = $data -> longitude; 
}*/ 
//7.2 Method 2: Use ipinfodb.com api
if ($radius != 0) {
	$arr_location=file_get_contents('http://api.ipinfodb.com/v3/ip-city/?key=9f7c2cc78e895efaaed194174c1ce4dfce13f831103e6b6d65837f152a9c6a33&ip=125.163.77.77');
	$loc = (explode(";",$arr_location));
	$lat = $loc[8];
	$long = $loc[9];
}

//8. Earthquake Epicentrum
$epi_lat = 0;
$epi_long = 0;
if ($radius != 0) {
	$epi_lat = $xml -> gempa -> Lintang;
	if (strpos($epi_lat, 'LS') == true) { //Indonesia located from LU (Lintang Utara/North Latitude) to LS (Lintang Selatan/South Latitude) so a checker must be made
		$epi_lat = str_replace(" LS", "", $epi_lat);
		$epi_lat = $epi_lat * -1;
	} else {
		$epi_lat = str_replace(" LU", "", $epi_lat);
	}
	$epi_long = $xml -> gempa -> Bujur; //Indonesia located only in BT (Bujur Timur/East Longitude) so checker is unnecessary
	$epi_long = str_replace(" BT", "", $epi_long);
}

//9. Earthquake Epicentrum -- User Location Distance and IsFelt 
//distance() from geodatasource.php (included)
$IsFelt = False;
$distance = 0;
if ($epi_lat != 0 and $epi_long != 0){ //0,0 lat-long is excluded from case since no place in Indonesia located there
	$distance = distance($epi_lat, $epi_long, $lat, $long, "K");
	if (($radius - $distance) >= 0){
		$IsFelt = true;
	}
} 
	
?>
