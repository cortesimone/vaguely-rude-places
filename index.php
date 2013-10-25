<?php
$path = '../mobile-detect';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);
require_once('Mobile_Detect.php');
?>
<html>
<head>
	<title>Simone Cortesi | Luoghi Vagamente Volgari</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.5/leaflet.css" />
	<!--[if lte IE 8]>
	<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.5/leaflet.ie.css" />
	<![endif]-->
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<script src="http://cdn.leafletjs.com/leaflet-0.5/leaflet.js"></script>
	<script type="text/javascript" src="http://maps.stamen.com/js/tile.stamen.js?v1.2.1"></script>
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/rude-geojson.js"></script>
	<script type="text/javascript" src="js/rude.js"></script>

<?php
	$detect = new Mobile_Detect();
	$protocol = 'http';
	$id = NULL;
	if (isset($_SERVER['HTTPS'])) {
		$protocol = filter_var($_SERVER['HTTPS'], FILTER_SANITIZE_URL);
	}
	$server = $protocol . '://' . filter_var($_SERVER['SERVER_NAME'], FILTER_SANITIZE_URL);
	$port = filter_var($_SERVER['SERVER_PORT'], FILTER_SANITIZE_NUMBER_INT);
	if ($port != 80) {
		$server .= ':' . $port;
	}
	$server .= filter_var($_SERVER['SCRIPT_NAME'], FILTER_SANITIZE_URL);
	if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
		$id = filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT);
	}

	$script = array();
	$script[] = '<script type="text/javascript">';
	$script[] = 'var RudePlacesMap = {';
	$script[] = '	server_name: ' . "'" . $server . "',";

	if (isset($id) && !empty($id)) {
		$script[] = '	place_id: ' . "'" . $id . "',";
	}

	if ($detect->isMobile() || $detect->isTablet() || $detect->isiOS()) {
		$script[] = '	mobile: true'; 
	}

	else {
		$script[] = '	mobile: false';
	}

	$script[] = '}';
	$script[] = '</script>';
	
	echo implode(PHP_EOL, $script);
?>

	<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', '']);
	_gaq.push(['_setDomainName', 'maps.cortesi.com']);
	_gaq.push(['_trackPageview']);

	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
	</script>
</head>
<body>
<?php
if (!$detect->isMobile() && !$detect->isTablet() && !$detect->isiOS()) {
?>
	<a href="https://github.com/simonecortesi/vaguely-rude-places"><img style="position: absolute; top: 0; right: 0; border: 0; z-index:100;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png" alt="Fork me on GitHub"></a>
<?php
}
?>
	<div id="header"><a href="/rude/index.php">Luoghi il cui nome risulta Vagamente Volgare</a></div>
	<div id="map"></div>
	<div id="footer">
		<div id="credits">
			<a href="/">Altre mappe</a>. Questo è un lavoro di <a href="http://cortesi.com/" target="_blank">Simone Cortesi</a>, fortemente ispirato da <a href="http://www.garygale.com/" target="_blank">Gary Gale</a>, realizzato con PHP, HTML, CSS e jQuery. <a href="images/county.png" target="_blank">icona Country</a> <a href="http://creativecommons.org/licenses/by-sa/3.0" target="_blank">CC BY SA 3.0</a>; di <a href="http://mapicons.nicolasmollet.com/" target="_blank">Nicolas Mollet</a>.
		</div>
		<div id="attribution">
			&copy; <a href="http://cortesi.com/" target="_blank">Simone Cortesi</a>; contenuto licenziato con <a href="http://creativecommons.org/licenses/by/3.0" target="_blank">licenza CC BY 3.0</a>; sorgente licenziato con <a href="http://opensource.org/licenses/BSD-2-Clause" target="_blank">licenza BSD</a>. <a href="http://maps.stamen.com/" target="_blank">Mappa</a> di <a href="http://stamen.com/" target="_blank">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0" target="_blank">CC BY 3.0</a>. &copy; <a href="http://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a> contributors.
		</div>
	</div>
</body>



