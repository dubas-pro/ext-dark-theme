<?php

/**
 * This file is part of the Dubas Dark Theme - EspoCRM extension.
 *
 * DUBAS S.C. - contact@dubas.pro
 * Copyright (C) 2023-2025 Arkadiy Asuratov, Emil Dubielecki
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

use PHP_CodeSniffer\Standards\PSR2\Sniffs\Namespaces\UseDeclarationSniff;
use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use PhpCsFixer\Fixer\Comment\HeaderCommentFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoEmptyReturnFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

$extension = json_decode(file_get_contents(__DIR__ . '/extension.json'));
$header = 'This file is part of the Dubas Dark Theme - EspoCRM extension.

%s
Copyright (C) %s-%s %s

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.';

return ECSConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
    ])
    ->withRootFiles()

    ->withRules([
        UseDeclarationSniff::class,
        NoUnusedImportsFixer::class,
        OrderedClassElementsFixer::class,
    ])

    ->withConfiguredRule(HeaderCommentFixer::class, [
        'header' => sprintf(
            $header,
            $extension->name,
            $extension->author,
            date('Y', strtotime($extension->releaseDate)),
            date('Y'),
            implode(', ', $extension->authors)
        ),
        'comment_type' => HeaderCommentFixer::HEADER_PHPDOC,
        'location' => 'after_open',
        'separate' => 'bottom',
    ])

    ->withPreparedSets(
        arrays: true,
        namespaces: true,
        spaces: true,
        docblocks: true,
        comments: true,
    )

    ->withSkip([
        NotOperatorWithSuccessorSpaceFixer::class,
        PhpdocNoEmptyReturnFixer::class,
    ])

    ;
