<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Jukebox</title>
	<style media="screen" type="text/css">
		#container {
			display: table;
		}
		#row  {
			display: table-row;
		}
		#leftCont {
			display: table-cell;
			width: 30px;
		}
		#centCont {
			display: table-cell;
		}
		#rightCont {
			display: table-cell;
			width: 30px;
		}
	</style>
</head>

<body onload="playAudio()">
	<body background="background2.jpg"></body>
	<center>
		<h1><font face="DroidSans" size="6" color="white">JUKEBOX</font></h1>

		<span>
			<font color="white" face="DroidSans" size="3">Enter all or part of a song name to display a list 
				of songs found on Spotify. Then select the songs that you wish to put into the list.
			</font>
		</span>

		<form action="index_find_song.php" method="GET">
			<font color="white" face="DroidSans" size="3"> Song Name:</font>
			<input type="text" name="song" autofocus="autofocus" value="">
			<input type="submit" value="Submit">
		</form>	
	</center>

	<br>

	<div id="leftCont"><p></p></div>
	<div id="centCont">
		<?php
		$file      = fopen( "songs.txt" , "r" );
		$first     = fgets( $file );
		$firsturl  = fgets( $file );
		$firsttime = fgets( $file );
		$first     = preg_replace( '/\s+/' , '' , $first );
		$firsturl  = preg_replace( '/\s+/' , '' , $firsturl );
		$firsttime = preg_replace( '/\s+/' , '' , $firsttime );

		echo "<font color=\"white\">";

		if( $first != "" )
		{
			echo "<center>";
			echo "<p><font face=\"DroidSans\" size=\"3\"><pre>Now Playing:</pre></font></p>";

			$url = "https://embed.spotify.com/?uri=".$first;
			echo "<iframe src=\"".$url."\" width=\"300\" height=\"380\" frameborder=\"0\" allowtransparency=\"true\"></iframe>";

			// echo "<script>";
			// echo "function getSkips(int) {
			// 	if (window.XMLHttpRequest) {
			// 		xmlhttp=new XMLHttpRequest();
			// 	} else {  // code for IE6, IE5
			// 		xmlhttp=new ActiveXObject(\"Microsoft.XMLHTTP\");
			// 	}
			// 	xmlhttp.onreadystatechange=function() {
			// 		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			// 			document.getElementById(\"poll\").innerHTML=xmlhttp.responseText;
			// 		}
			// 	}
			// 	xmlhttp.open(\"GET\",\"index_get_skips.php?skip=\"+int,true);
			// 	xmlhttp.send();
			// }";
			// echo "</script>";

			// echo "<div id=\"poll\">
			// <h3>Skip next song?</h3>
			// <form>
			// 	Yes:
			// 	<input type=\"radio\" name=\"skip\" value=\"0\" onclick=\"getSkips(this.value)\">
			// 	<br>
			// 	No:
			// 	<input type=\"radio\" name=\"skip\" value=\"1\" onclick=\"getSkips(this.value)\">
			// </form></div>";

			echo "<p><font face=\"DroidSans\" size=\"3\"><pre>Next:</pre></font></p>";
			echo "</center>";

			$count = 0;
			echo "<center>";
			while( !feof( $file ) )
			{
				$line = fgets( $file );
				if( $count % 3 == 0 )
				{
					if( $line != "" )
					{
						$url = "https://embed.spotify.com/?uri=".$line;
						echo "<iframe src=\"".$url."\" class=\"horiz\" width=\"300\" height=\"380\" frameb9order=\"0\" allowtransparency=\"true\"></iframe>";
					}
				}
				$count++;
			}
			echo "</center>";
		}

		echo "</font>";
		fclose( $file );
		?>
	</div>
	<div id="rightCont"><p></p></div>

	<script type="text/javascript">
		var url  = <?php echo json_encode( $firsturl ); ?>;
		var time = <?php echo json_encode( $firsttime ); ?>;
		var time = parseInt( time );
		time += 10000;

		var win;
		function playAudio()
		{

			if( url )
			{
				createWindow();
			// setInterval( function(){ checkSkips(); } , 1000 );
		}
		else
		{
			setTimeout( function(){ window.location.reload(1); } , 10000 );
		}
		
	}
	function createWindow()
	{
		win = window.open( url , "_blank", "width=200, height=100", "win" );
		win.onclose = function() { afterClosed(); }
		setTimeout( function(){ closeWindow(); } , time );
		checkSkips();
	}
	function closeWindow()
	{
		win.close();
		window.location.href = "index_delete_song.php";
	}
	function checkSkips()
	{
		<?php
		$file = fopen( "skips.txt" , "r'" );
		$line = fgets( $file );
		$array = explode( "||" , $line );
		$yes = $array[0];
		$no  = $array[1];
		fclose( $file );
		?>

		var yes = <?php echo json_encode( $yes ); ?>;
		var no  = <?php echo json_encode( $no ); ?>;
		var total = yes + no;
		var diff  = yes - no;

		if( total >= 3 && diff >= 3 )
		{
			<?php
			$file = fopen( "songs.txt" , "r" );
			$file2 = fopen( "temp.txt" , "w" );
			$uri = fgets( $file );
			$url = fgets( $file );
			$time= fgets( $file );
			fwrite( $file2 , $uri );
			fwrite( $file2 , $url );
			fwrite( $file2 , $time );
			$uri = fgets( $file );
			$url = fgets( $file );
			$time= fgets( $file );
			while( !feof( $file ))
			{
				$item = fgets( $file );
				fwrite( $file2 , $item );
			}
			fclose( $file );
			fclose( $file2 );

			$file = fopen( "songs.txt" , "w" );
			$file2 = fopen( "temp.txt" , "r" );
			while( !feof( $file2 ))
			{
				$item = fgets( $file2 );
				fwrite( $file , $item );
			}
			fclose( $file );
			fclose( $file2 );
			?>
			closeWindow();
		}
		setTimeout( function(){ checkSkips(); } , 1000 );
	}

</script>


</body>
</html>