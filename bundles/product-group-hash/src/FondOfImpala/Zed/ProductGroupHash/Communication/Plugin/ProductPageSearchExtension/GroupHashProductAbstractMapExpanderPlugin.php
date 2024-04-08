<?php

namespace FondOfImpala\Zed\ProductGroupHash\Communication\Plugin\ProductPageSearchExtension;

use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\PageMapTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearchExtension\Dependency\PageMapBuilderInterface;
use Spryker\Zed\ProductPageSearchExtension\Dependency\Plugin\ProductAbstractMapExpanderPluginInterface;

class GroupHashProductAbstractMapExpanderPlugin extends AbstractPlugin implements ProductAbstractMapExpanderPluginInterface
{
    /**
     * @var string
     */
    public const KEY_GROUP_HASH = 'group_hash';

    /**
     * @param \Generated\Shared\Transfer\PageMapTransfer $pageMapTransfer
     * @param \Spryker\Zed\ProductPageSearchExtension\Dependency\PageMapBuilderInterface $pageMapBuilder
     * @param array $productData
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\PageMapTransfer
     */
    public function expandProductMap(
        PageMapTransfer $pageMapTransfer,
        PageMapBuilderInterface $pageMapBuilder,
        array $productData,
        LocaleTransfer $localeTransfer
    ) {
        if (!isset($productData[static::KEY_GROUP_HASH])) {
            return $pageMapTransfer;
        }

        $pageMapBuilder->addSearchResultData(
            $pageMapTransfer,
            static::KEY_GROUP_HASH,
            $productData[static::KEY_GROUP_HASH]
        );

        return $pageMapTransfer->setGroupHash($productData[static::KEY_GROUP_HASH]);
    }
}
