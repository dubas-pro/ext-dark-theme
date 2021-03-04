<?php

declare(strict_types=1);

/*
 * This document has been generated with
 * https://mlocati.github.io/php-cs-fixer-configurator/#version:2.16.4|configurator
 * you can change this configuration by importing this file.
 */

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
// use Symplify\EasyCodingStandard\Configuration\Option;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__.'/src',
        __DIR__.'/tests',
    ]);

    $parameters->set(Option::SKIP, [
        __DIR__.'/vendor',
    ]);

    $parameters->set(Option::SETS, [
        SetList::CLEAN_CODE,
        SetList::PSR_12,
    ]);

    $services = $containerConfigurator->services();
    $services->set(PhpCsFixer\Fixer\Comment\HeaderCommentFixer::class)
             ->call('configure', [[
                'header' => <<<EOT
                This file is part of the Dubas Dark Theme for EspoCRM.

                (c) DUBAS S.C.
                Website: https://dubas.pro
                                
                For the full copyright and license information, please view the LICENSE
                file that was distributed with this source code.
                EOT,
                'location' => 'after_open',
                ]]);
};