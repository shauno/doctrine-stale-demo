<?php

require_once "../vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$config = Setup::createAnnotationMetadataConfiguration(["src/Models"], true, null, null, false);
$entityManager = EntityManager::create([
	'driver'   => 'pdo_mysql',
	'user'     => 'root',
	'password' => '',
	'dbname'   => 'stale-test-tmp',
], $config);


$user = new \Demo\Models\UserModel();
print('<pre>');
\Doctrine\Common\Util\Debug::dump($user);
exit;

