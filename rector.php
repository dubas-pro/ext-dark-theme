<?php

declare(strict_types=1);

use Rector\CodingStyle\Rector\If_\NullableCompareToNullRector;
use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Set\ValueObject\DowngradeSetList;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;
use Rector\TypeDeclaration\Rector\FunctionLike\ParamTypeDeclarationRector;
use Rector\TypeDeclaration\Rector\Param\ParamTypeFromStrictTypedPropertyRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(DowngradeSetList::PHP_74);
    $containerConfigurator->import(SetList::PHP_73);
    $containerConfigurator->import(SetList::CODE_QUALITY);
    $containerConfigurator->import(SetList::DEAD_CODE);

    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::PHP_VERSION_FEATURES, PhpVersion::PHP_73);

    $parameters->set(Option::PATHS, [
        __DIR__ . '/ecs.php',
        __DIR__ . '/rector.php',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    $parameters->set(Option::AUTOLOAD_PATHS, [
        __DIR__ . '/site',
    ]);

    $parameters->set(Option::SKIP, [
        __DIR__ . '**/vendor/**',
    ]);

    $services = $containerConfigurator->services();

    $services->set(NullableCompareToNullRector::class);
    $services->set(AddVoidReturnTypeWhereNoReturnRector::class);
    $services->set(ParamTypeFromStrictTypedPropertyRector::class);
    $services->set(ParamTypeDeclarationRector::class);
};
