<html>
<head>
	<title>Hello world!</title>
	<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
	<style>
	body {
		background-color: white;
		text-align: center;
		padding: 50px;
		font-family: "Open Sans","Helvetica Neue",Helvetica,Arial,sans-serif;
	}

	#logo {
		margin-bottom: 40px;
	}
	</style>
</head>
<body>
	<img id="logo" src="logo.png" />
	<h1><?php echo "Hello ".($_ENV["NAME"]?$_ENV["NAME"]:"world")."!"; ?></h1>
	<?php if($_ENV["HOSTNAME"]) {?><h3>My hostname is <?php echo $_ENV["HOSTNAME"]; ?></h3><?php } ?>

	<h2>Memcached</h2>
	<?php
	$memcache = new Memcache;
	$memcache->connect('memservice', 11211) or die ("Could not connect");

	$version = $memcache->getVersion();
	echo "<p>Server's version: ".$version."</p>\n";

	echo "<p>Setting data on memcached</p>\n<ul>\n";
	for($i = 0; $i < 100; $i++) {
		$rand_key = mt_rand(0, 10000);
		$rand_value = rand();
		echo "<li>Setting key $rand_key</li>\n";
		$memcache->set($rand_key, $rand_value, false, 300) or die ("Failed to save data at the server");
	}
	echo "</ul>\n";
	
	$get_result = $memcache->get(mt_rand(0, 10000));
	echo "<p>Data from the cache:<br/></p>\n";
	var_dump($get_result);
	?>

</body>
</html>

<?php
// Random sleep interval to have more realistic latency
usleep(rand(100000, 500000));
?>
