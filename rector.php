<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\Php80\Rector\FunctionLike\MixedTypeRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/bundles/*/src',
        __DIR__ . '/bundles/*/tests',
    ]);

    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_80,
        SetList::TYPE_DECLARATION,
    ]);

    $rectorConfig->skip([
        MixedTypeRector::class,
        ClassPropertyAssignToConstructorPromotionRector::class,
    ]);

    $rectorConfig->importNames(true, false);
};
