<?php

return new \Phalcon\Config(array(
	'database' => array(
		'adapter'     => 'Sqlite',
		'host'        => '',
		'username'    => '',
		'password'    => '',
		'dbname'      => __DIR__ . '/../../app/db/test.sqlite3',
	),
	'application' => array(
		'controllersDir' => __DIR__ . '/../../app/controllers/',
		'modelsDir'      => __DIR__ . '/../../app/models/',
		'viewsDir'       => __DIR__ . '/../../app/views/',
		'pluginsDir'     => __DIR__ . '/../../app/plugins/',
		'libraryDir'     => __DIR__ . '/../../app/library/',
		'cacheDir'       => __DIR__ . '/../../app/cache/',
		'baseUri'        => '/public/',
	)
));
