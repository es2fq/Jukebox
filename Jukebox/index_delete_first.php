<!DOCTYPE html>
<html>
<body>
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

	header( "Location: jukebox.php" );
	?>
</body>
</html>