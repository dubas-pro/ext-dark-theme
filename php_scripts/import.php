<?php

include '../site/bootstrap.php';

use Espo\Core\Application;
use Espo\Core\InjectableFactory;
use Espo\Core\Utils\Crypt;
use Espo\Core\Utils\PasswordHash;
use Espo\ORM\EntityManager;

$app = new Application();
$app->setupSystemUser();

$entityManager = $app->getContainer()->getByClass(EntityManager::class);
$passwordHash = $app->getContainer()->getByClass(InjectableFactory::class)->create(PasswordHash::class);
$crypt = $app->getContainer()->getByClass(InjectableFactory::class)->create(Crypt::class);

if (!file_exists('../tests/fixtures/init.php')) {
    echo 'File with test data not found' . PHP_EOL;
    exit(0);
}

$data = include '../tests/fixtures/init.php';
$data = $data['entities'];

foreach ($data as $entityType => $collection) {
    foreach ($collection as $entityData) {
        $entityId = $entityData['id'] ?? null;

        $entityManager->getQueryExecutor()->execute(
            $entityManager
                ->getQueryBuilder()
                ->delete()
                ->from($entityType)
                ->where([
                    'id' => $entityId,
                ])
                ->build(),
        );

        $entity = $entityManager->getEntity($entityType);

        $saveOptions = [];

        foreach ($entityData as $field => $value) {
            if ('createdById' === $field) {
                $saveOptions[$field] = $value;

                continue;
            }

            if ('password' === $field) {
                $value = $passwordHash->hash($value);
            }

            if (in_array($entityType, ['EmailAccount', 'InboundEmail'], true)) {
                if ('password' === $field) {
                    $value = $crypt->encrypt($value);
                }

                if ('smtpPassword' === $field) {
                    $value = $crypt->encrypt($value);
                }
            }

            $entity->set($field, $value);
        }

        $entityManager->saveEntity($entity, $saveOptions);
    }
}
