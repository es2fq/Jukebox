<!DOCTYPE html>
<html>
<body>
	<?php

	//Rewrite file
	$file = fopen( "songs.txt" , "r" );
	$file2 = fopen( "temp.txt" , "w" );
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

	//Clear skips.txt
	$file = fopen( "skips.txt" , "w" );

	header( "Location: jukebox.php" );
	?>
</body>
</html>