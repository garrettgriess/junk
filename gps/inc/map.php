<?
//Heading to Direction
function getDirection($bearing) {
	$cardinalDirections = array(
		'N' => array(337.5, 22.5), 
		'NE' => array(22.5, 67.5), 
		'E' => array(67.5, 112.5), 
		'SE' => array(112.5, 157.5), 
		'S' => array(157.5, 202.5), 
		'SW' => array(202.5, 247.5), 
		'W' => array(247.5, 292.5), 
		'NW' => array(292.5, 337.5) 
	);
	$direction = 'N';
	foreach ($cardinalDirections as $dir => $angles) {
		if ($bearing >= $angles[0] && $bearing < $angles[1])  {
			$direction = $dir; 
			break;
		} 
	}
	return $direction;
}
?>
<!DOCTYPE html> 
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="refresh" content="120">
	<title>GPS</title>
	
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-111808018-7"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
	  gtag('config', 'UA-111808018-7');
	</script>
	
	<style>
		html, body, #map {
			height: 100%;
			width: 100%;
			margin: 0;
            padding: 0;
		}
		#infowindow th {
			color: #003D5A;
			font-size: 24px;
			padding-left: 10px;
			padding-top: 10px;
		}
		#infowindow td {
			text-align: center;
			font-size: 18px;
			padding-left: 10px;
			padding-bottom: 10px;
		}
    </style>
	
	<link rel="apple-touch-icon" sizes="60x60" href="http://garrettgriess.com/ico/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="76x76" href="http://garrettgriess.com/ico/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="120x120" href="http://garrettgriess.com/ico/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="152x152" href="http://garrettgriess.com/ico/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="http://garrettgriess.com/ico/apple-touch-icon-180x180.png">
	<link rel="icon" type="image/png" href="http://garrettgriess.com/ico/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="http://garrettgriess.com/ico/favicon-194x194.png" sizes="194x194">
	<link rel="icon" type="image/png" href="http://garrettgriess.com/ico/android-chrome-192x192.png" sizes="192x192">
	<link rel="icon" type="image/png" href="http://garrettgriess.com/ico/favicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="http://garrettgriess.com/ico/manifest.json">
	<link rel="mask-icon" href="http://garrettgriess.com/ico/safari-pinned-tab.svg" color="#00779b">
	<link rel="shortcut icon" href="http://garrettgriess.com/ico/favicon.ico">
	<meta name="msapplication-TileColor" content="#00779b">
	<meta name="msapplication-TileImage" content="http://garrettgriess.com/ico/mstile-144x144.png">
	<meta name="msapplication-config" content="http://garrettgriess.com/ico/browserconfig.xml">
	<meta name="theme-color" content="#00779b">
	
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

	<?
	$min_hacc=100; //Lowest Horizontal Accuracy
	$time_limit=date('YmdHis', strtotime('-1 day'));
	
	//Select Database
	$mysql_select = array('id','lat','lon','speed','heading','hacc','altitude','battery','ts');
	$mysql_results = mysql_select("gps",$mysql_select,"`lat` != '' AND `lon` != '' AND `hacc` <= ".$min_hacc." AND `ts` > ".$time_limit,"`ts` DESC",100);
	if (!is_array($mysql_results)) {
		echo $mysql_results;
	} else {
		$num = count($mysql_results);
	}
	
	//Get last regardless of time_limit
	if ($num==0) {
		$mysql_results = mysql_select("gps",$mysql_select,"`lat` != '' AND `lon` != '' AND `hacc` <= ".$min_hacc,"`ts` DESC",1);
		if (!is_array($mysql_results)) {
			echo $mysql_results;
		} else {
			$num = count($mysql_results);
		}
	}
	
	//Map Center
	if ($num>0) {
		$lat_default=$mysql_results[0]['lat']+0.002; //offset for infowindow
		$lon_default=$mysql_results[0]['lon'];
		$zoom=14;
	} else {
		$lat_default=40.606754;
		$lon_default=-97.859564;
		$zoom=4;
	}
	?>

	<div id="map"></div>
	<script>
	  var map;
	  var marker = [];
	  
	  function initMap() {
		map = new google.maps.Map(document.getElementById('map'), {
			center: {lat: <?=$lat_default?>, lng: <?=$lon_default?>},
			zoom: <?=$zoom?>,
			mapTypeId: 'terrain',			
			<?
            if(date("H")>20||date("H")<8) {
                require('map_styles_blue.json');
            } else { 
                require('map_styles_gray.json');
            }
            ?>
		});
		var iconBase = 'http://www.garrettgriess.com/ico/';
		var infowindow = new google.maps.InfoWindow({
			maxWidth: 300
		});
			
		<?
		//Display Photos
		if ($num>0) {
			for ($i=0; $i<$num; $i++) {
				foreach ($mysql_select as $val) {
					$$val=$mysql_results[$i][$val]; //Set Variables
				}

				?>
				var contentString_<?=$id?> = 
				'<div id="infowindow">'+
					'<table><tr>'+
						'<td colspan="3" style="padding-bottom: 0px; color:#888888;"><small>'+
						<? if ($hacc<=5) { ?>
							'Great'+
						<? } else if ($hacc<=10) { ?>
							'Good'+
						<? } else if ($hacc<=100) { ?>
							'Bad'+
						<? } else { ?>
							'Terrible'+
						<? } ?>
						' <i class="fa fa-signal" aria-hidden="true"></i>'+
						'</small></td>'+
					'</tr><tr>'+						
						'<th><i class="fa fa-calendar" aria-hidden="true"></i></th>'+
						'<th><i class="fa fa-clock-o" aria-hidden="true"></i></th>'+
						<? if ($battery<=0.125) { ?>
							'<th><i class="fa fa-battery-empty" style="color:#5a0000;" aria-hidden="true"></i></th>'+
						<? } else if ($battery<=0.375) { ?>
							'<th><i class="fa fa-battery-quarter" aria-hidden="true"></i></th>'+
						<? } else if ($battery<=0.625) { ?>
							'<th><i class="fa fa-battery-half" aria-hidden="true"></i></th>'+
						<? } else if ($battery<=0.875) { ?>
							'<th><i class="fa fa-battery-three-quarters" aria-hidden="true"></i></th>'+
						<? } else { ?>
							'<th><i class="fa fa-battery-full" aria-hidden="true"></i></th>'+
						<? } ?>
					'</tr><tr>'+
						'<td><?=date('m/d/y',strtotime($ts))?></td>'+
						'<td><?=date('g:i',strtotime($ts))?><small><?=date('A',strtotime($ts))?></small>'+
						'<td><?=$battery*100?><small>%</small></td>'+
					'</tr><tr>'+
						'<th><i class="fa fa-tachometer" aria-hidden="true"></i></th>'+
						'<th><i class="fa fa-compass" aria-hidden="true"></i></th>'+
						<? if (round($altitude*3.28084)>7000) { ?>
							'<th><i class="fa fa-rocket" aria-hidden="true"></i></th>'+
						<? } else if (round($altitude*3.28084)>100) { ?>
							'<th><i class="fa fa-plane" aria-hidden="true"></i></th>'+
						<? } else { ?>
							'<th><i class="fa fa-ship" aria-hidden="true"></i></th>'+
						<? } ?>
					'</tr><tr>'+
						'<td><? if ($speed<0) { ?>N/A<? } else { ?><?=round($speed*(2+(331/1397)))?><small>mph</small><? } ?></td>'+
						'<td><? if ($heading<0) { ?>N/A<? } else { ?><?=getDirection($heading)?><? } ?></td>'+
						'<td><?=round($altitude*3.28084)?><small>ft</small></td>'+
					'</tr></table>'+
				'</div>';

				var marker_<?=$id?> = new google.maps.Marker({
					<? if ($i==0) { ?>
					icon: iconBase + 'favicon-32x32.png',
					<? } else { ?>
					icon: {
						<? if ($heading<0||$speed<0) { ?>
							path: google.maps.SymbolPath.CIRCLE,
						<? } else { ?>
							path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
							rotation: <?=$heading?>,
						<? } ?>
						scale: 4,
						
						<? if (round($speed*(2+(331/1397)),2)>20) { ?>
							fillColor: '#7fd489', //fast
						<? } else if (round($speed*(2+(331/1397)),2)>10) { ?>
							fillColor: '#cfd47f', //med
						<? } else { ?>
							fillColor: '#d47f7f', //slow
						<? } ?>
						
						fillOpacity: <?=(($num+1-$i)/$num)?>,
						strokeWeight: 1,
						strokeColor: '#000000',
						strokeOpacity: <?=(($num+1-$i)/$num)?>
					},
					<? } ?>
					position: {lat: <?=$lat?>, lng: <?=$lon?>},
					map: map,
					optimized: false,
					title: '<?=date('l, M j, Y - g:i:s A',strtotime($ts))?>',
					zIndex:<?=1000-$i?>
				});
				
				<? if ($i==0) { ?>
					infowindow.setContent(contentString_<?=$id?>);
					infowindow.open(map,marker_<?=$id?>);
				<? } ?>
				
				var mouseoverTimeoutId = null;
				google.maps.event.addListener(marker_<?=$id?>,'click', function() { 
					infowindow.close()
					infowindow.setContent(contentString_<?=$id?>);
					infowindow.open(map,marker_<?=$id?>);
				});
				
				<?

			}
		}
		?>
		
	  }
	</script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?=$google_maps_key?>&callback=initMap"></script>
	
</body>
</html>
