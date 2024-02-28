<?php

declare(strict_types=1);

use Rector\CodingStyle\Rector\FuncCall\CountArrayToEmptyArrayComparisonRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\Php80\Rector\FuncCall\ClassOnObjectRector;
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
        SetList::DEAD_CODE,
        SetList::CODING_STYLE,
        SetList::EARLY_RETURN,
    ]);

    $rectorConfig->skip([
        MixedTypeRector::class,
        ClassOnObjectRector::class,
        ClassPropertyAssignToConstructorPromotionRector::class,
        RemoveUselessParamTagRector::class,
        RemoveUselessReturnTagRector::class,
        CountArrayToEmptyArrayComparisonRector::class,
    ]);

    $rectorConfig->importNames(true, false);
};
