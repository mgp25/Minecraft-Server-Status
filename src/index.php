<?php
require __DIR__ . '/MinecraftPing.php';
require __DIR__ . '/MinecraftPingException.php';
require __DIR__ . '/MinecraftSkin.php';

///////////// CONFIG /////////////
$SERVER_URL = null; // Don't set it if you dont have a server url
$SERVER_IP 	= '';
$PORT 			= '';

$players = array('test', 'test1'); // players to be displayed
//////////////////////////////////

$mc = new MinecraftSkin();

foreach ($players as $player)
{
	$mc->getFace($player);
}
try
{
		$Query = new MinecraftPing( $SERVER_IP, $PORT );

		$data = $Query->Query();
		$status = 'online';
}
catch( MinecraftPingException $e )
{
		echo $e->getMessage();
		$status = 'offline';
}
finally
{
		$Query->Close();
}

?>
<!DOCTYPE html>
<html>
	<head>
        <meta charset="utf-8">
        <title>Minecraft Server Status</title>
        <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css">
			<link rel="shortcut icon" href="https://mgp25.com/mc/favicon.ico">
			<link href='http://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>
    	<link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    	<script type="text/javascript" src="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
    	<script>
    	jQuery(function ($) {
        	$("a").tooltip()
    	});
    	</script>
    	<style>
    	/*Custom CSS Overrides*/
    	body {
      		font-family: 'Lato', sans-serif !important;
    	}
    	</style>
    </head>
    <body>
	<div class="container">
        <h1>Minecraft Server Status</h1><hr>
		<div class="row">
			<div class="span4">
				<h3>General Information</h3>
				<table class="table table-striped">
					<tbody>
					<tr>
					<td><b>IP</b></td>
					<td><?php if (isset($SERVER_URL)) echo $SERVER_URL; else echo $SERVER_IP; echo ':' . $PORT; ?></td>
					</tr>
					<tr>
					<td><b>Version</b></td>
					<td><?php echo $data['version']['name']; ?></td>
					</tr>
					<tr>
					<td><b>Players</b></td>
					<td><?php echo "".$data['players']['online']." / ".$data['players']['max']."";?></td>
					</tr>
					<tr>
					<td><b>Status</b></td>
					<td><? if($status == 'online') { echo "<i class=\"icon-ok-sign\"></i> Server is online"; } else { echo "<i class=\"icon-remove-sign\"></i> Server is offline";}?></td>
					</tr>
					<tr>
					<td><b>Description</b></td>
					<td><?php echo "".$data['description']; ?></td>
					</tr>
					<td><b>Server image</b></td>
					<td><?php echo '<img width="64" height="64" src="' . Str_Replace( "\n", "", $data[ 'favicon' ] ) . '">'; ?></td>
					</tr>
					<td><b>Mods</b></td>
					<td><?php
					if(isset($data['modinfo']['modList'])) { foreach ($data['modinfo']['modList'] as $mod) {$mods[] = $mod['modid'] . ' ' . $mod['version'];} echo implode(', ', array_unique($mods)); } ?></td>
					</tr>
					</tbody>
				</table>
			</div>
			<div class="span8">
				<h3>Players</h3>
				<?php
				foreach($players as $key) {
					$users .= "<a data-placement=\"top\" rel=\"tooltip\" style=\"display: inline-block;\" title=\"".$key."\">
					<img src=\"faces/" .$key."_face.png\" size=\"40\" width=\"40\" height=\"40\" style=\"width: 40px; height: 40px; margin-bottom: 5px; margin-left: 5px; border-radius: 3px;\"/></a>";
				}
				if($data['players'] > 0) {
					print_r($users);
					}
				else {
					echo "<div class=\"alert\"> There are no players online at the moment!</div>";
					}
				?>
			</div>
		</div>
	</div>
	</body>
</html>
