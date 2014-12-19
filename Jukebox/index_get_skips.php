<?php
$skip = $_REQUEST['skip'];

//get content of textfile
$filename = "skips.txt";
$content = file( $filename );

//put content in array
$array = explode( "||", $content[0] );
$yes = $array[0];
$no  = $array[1];

if ( $skip == 0 ) {
	$yes = $yes + 1;
}
if ( $skip == 1 ) {
	$no = $no + 1;
}

//insert skips to txt file
$insertskip = $yes."||".$no;
$fp = fopen( $filename,"w" );
fputs( $fp,$insertskip );
fclose( $fp );
?>

<div id="div">
	<h2><font face="DroidSans" size="6" color="white">Result: (Must have 3 more yes than no)</font></h2>
	<table>
		<tr>
			<td><font face="DroidSans" size="3" color="white">Yes:</font></td>
			<td>
				<img src="poll.gif"
				width='<?php echo( 100*round( $yes/( $no+$yes ),2 ) ); ?>'
				height='20'>
				<?php echo( $yes ); ?>
			</td>
		</tr>
		<tr>
			<td><font face="DroidSans" size="3" color="white">No:</font></td>
			<td>
				<img src="poll.gif"
				width='<?php echo( 100*round( $no/( $no+$yes ),2 ) ); ?>'
				height='20'>
				<?php echo( $no ); ?>
			</td>
		</tr>
	</table>
</div>