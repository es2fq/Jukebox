<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Song List</title>
	<style media="screen" type="text/css">

		#container {
			display: table;
		}
		#row  {
			display: table-row;
		}
		#leftCont {
			display: table-cell;
			width: 100px;
		}
		#centCont {
			display: table-cell;
		}
		#rightCont {
			display: table-cell;
			width: 100px;
		}
	</style>
</head>

<body>
	<body background="background2.jpg"></body>
	<div id="leftCont"><p></p></div>
	<div id="centCont">	
		<?php
		echo "<h1><font face=\"DroidSans\" size=\"6\" color=\"white\">Song List</font></h1>";
		echo "<span><font face=\"DroidSans\" size=\"3\" color=\"white\">Click on the song title or image to preview the song.</font></span>";
		echo "<br>";
		echo "<span><font face=\"DroidSans\" size=\"3\" color=\"white\">After adding your songs click the \"Done\" button.</font></span>";
		echo "<br>";
		echo "<br>";
		echo "<span><font face=\"DroidSans\" size=\"5\" color=\"white\">Search Again:</font></span>";
		echo "<form action=\"index_find_song.php\" method=\"GET\">
		<font color=\"white\" face=\"DroidSans\" size=\"3\"> Song Name:</font>
		<input type=\"text\" name=\"song\" autofocus=\"autofocus\" value=\"\">
		<input type=\"submit\" value=\"Submit\">
	</form>	";
	?>
	<br>
	<form action="jukebox.php" method="POST">
		<input type="submit" value="Done">
	</form>
	<?php

	$p = $_GET["song"];
	$p = str_replace( ' ' , '%20' , $p );
	if( $p == '' )     header( "Location: jukebox.php" );
	if( $p == "clr" )  header( "Location: index_clear.php" );
	if( $p == "del" )  header( "Location: index_delete_song.php" );
	if( $p == "del1" ) header( "Location: index_delete_first.php" );

	$url = 'https://api.spotify.com/v1/search?q='.$p.'&type=track';
	$ch  = curl_init( $url ); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$json   = curl_exec( $ch );
	$str    = json_encode( $json );
	$string = json_decode( $json , true );

	echo "<font color=\"white\">";
			// echo "<ol>";
			// echo "<li>";
	foreach( $string['tracks']['items'] as $item ) {
		echo "<hr>";

		$name = $item['name'];
		$link = $item['external_urls']['spotify'];
		$uri  = $item['uri'];
		$img  = $item['album']['images'][0]['url'];
		$hgt  = $item['album']['images'][0]['height'] / 2;
		$width= $item['album']['images'][0]['width'] / 2;
		$time = $item['duration_ms'];
		$prvw = $item['preview_url'];
		$bad  = $item['explicit'];

		echo "<a target=_blank href=".$link."><font face=\"DroidSans\" size=\"2\" color=\"white\">".$name."</font></a>";
		echo "</font>";
		?>
		<form action="index_add_song.php" method="POST">
			<input type="hidden" name="uri" value="<?php echo $uri; ?>">
			<input type="hidden" name="song" value="<?php echo $link; ?>">
			<input type="hidden" name="time" value="<?php echo $time; ?>">
			<input type="hidden" name="bad" value="<?php echo $bad; ?>">
			<input type="submit" value="Add Song">
		</form>
		<?php
		echo "<font color=\"white\">";
		echo "<a target=_blank href=".$prvw."><img src =".$img." height=".$hgt." width=".$width.">";
		echo "<br>";
		echo "<br>";
	}
			// echo "</li>";
			// echo "</ol>";
	echo "</font>";
	echo "<hr>";
	?>
	<form action="jukebox.php" method="POST">
		<input type="submit" value="Done">
	</form>
</div>
<div id="rightCont"><p></p></div>
</body>

</html>