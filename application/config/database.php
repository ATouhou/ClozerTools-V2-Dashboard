<?php
$services_json = json_decode(getenv("VCAP_SERVICES"),true);
$mysql_config = $services_json["mysql-5.1"][0]["credentials"];
return array(
	'profile' => true,
	'fetch' => PDO::FETCH_CLASS, 
	'default' => 'mysql_main',
	'connections' => array(
		'mysql_main' => array(
      		'driver'   => 'mysql',
      		'host'     => 'localhost',
      		'database' => 'clozertools-main',
      		'username' => 'root',
      		'password' => '',
      		'charset'  => 'utf8',
      		'prefix'   => '',
    		),'clozertools-tenant-data' => array(
      		'driver'   => 'mysql',
      		'host'     => 'localhost',
      		'database' => 'clozertools-tenant-data',
      		'username' => 'root',
      		'password' => '',
      		'charset'  => 'utf8',
      		'prefix'   => '',
    		),
	),
	'redis' => array(

		'default' => array(
			'host'     => '127.0.0.1',
			'port'     => 6379,
			'database' => 0
		),
	)
);