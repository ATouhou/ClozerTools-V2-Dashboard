<?php
$services_json = json_decode(getenv("VCAP_SERVICES"),true);
$main_database = $services_json["mysql-5.1"][0]["credentials"];
$tenant_datatables = $services_json["mysql-5.1"][1]["credentials"];
return array(
	'profile' => true,
	'fetch' => PDO::FETCH_CLASS, 
	'default' => 'mysql_main',
	'connections' => array(
		'mysql_main' => array(
			'driver'   => 'mysql',
			'host'     => $main_database['host'],
			'database' => $main_database['name'],
			'username' => $main_database['user'],
			'password' => $main_database['password'],
			'charset'  => 'utf8',
			'prefix'   => '',
		),
		'mysql_tenant_data' => array(
			'driver'   => 'mysql',
			'host'     => $tenant_datatables['host'],
			'database' => $tenant_datatables['name'],
			'username' => $tenant_datatables['user'],
			'password' => $tenant_datatables['password'],
			'charset'  => 'utf8',
			'prefix'   => '',
		)
	),
	'redis' => array(

		'default' => array(
			'host'     => '127.0.0.1',
			'port'     => 6379,
			'database' => 0
		),
	)
);
