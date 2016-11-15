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
	echo "Server's version: ".$version."<br/>\n";

	echo "Setting data on memcached";
	for($i = 0; $i < 100; $i++) {
		$memcache->set(mt_rand(0, 1000), rand(), false, 300) or die ("Failed to save data at the server");
	}
	
	$get_result = $memcache->get(mt_rand(0, 1000));
	echo "Data from the cache:<br/>\n";
	var_dump($get_result);
	?>

</body>
</html>

