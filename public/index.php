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

// Fetch user from the DB
// It looks like this result will get cached and override the result when this entity is retrieved in the transaction below :(
$query = $entityManager->createQuery('SELECT User FROM \Demo\Models\UserModel User WHERE User.id = :id');
$query->setParameter('id', 1);
$user1 = $query->getOneOrNullResult();

// Open a db transaction
$entityManager->getConnection()->beginTransaction();

// Select user again FOR UPDATE this time. This will wait to get a lock on the record
$query = $entityManager->createQuery('SELECT User FROM \Demo\Models\UserModel User WHERE User.id = :id');
$query->setParameter('id', 1);
$query->setLockMode(\Doctrine\DBAL\LockMode::PESSIMISTIC_WRITE);
$user = $query->getOneOrNullResult();

print('<pre>');
\Doctrine\Common\Util\Debug::dump($user);

$entityManager->getConnection()->rollBack();

