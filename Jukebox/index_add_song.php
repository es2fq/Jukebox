<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
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
	<?php
	$bool = false;
	$uri  = $_POST["uri"];
	$song = $_POST["song"];
	$time = $_POST["time"];
	$bad  = $_POST["bad"];

	$bad = preg_replace( '/\s+/' , '' , $bad );
	if( $bad == true )
	{
		echo "<center>";
		echo "<h1>";
		echo "<font color=\"white\" face=\"DroidSans\" size=\"10\">No explicit songs! Capiche?</font>";
		echo "</h1>";
		?>
		<form action="jukebox.php">
			<input type="submit" value="Capiche!">
		</form>
		<?php
		echo "<center>";
	}

	else
	{
		if( !file_exists( "songs.txt" ))
		{
			$file = fopen( "songs.txt" , "w" );
		}
		else 
		{
			$file = fopen( "songs.txt" , "r" );
			while( !feof( $file ))
			{
				$line = fgets( $file );
				$line = preg_replace( '/\s+/' , '' , $line );
				if( $line == $uri )
				{
					$bool = true;
				}
			}
		}
		fclose( $file );
		$file = fopen( "songs.txt" , "a+" );
		if( $bool == false )
		{
			fwrite( $file , $uri."\n" );
			fwrite( $file , $song."\n" );
			fwrite( $file , $time."\n" );
		}
		fclose( $file );
		header( "Location: {$_SERVER['HTTP_REFERER']}" );
	}
	?>
</body>

</html>