<?php

namespace FondOfImpala\Client\ProductImageGroupingProductPageSearch\Plugin\EnhancedCatalogExtension;

use Elastica\Result;
use FondOfImpala\Client\EnhancedCatalogExtension\Dependency\Plugin\ProductExpanderPluginInterface;
use FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Communication\Plugin\ProductPageSearch\ProductImageGroupMapExpanderPlugin;
use Generated\Shared\Transfer\RestCatalogSearchProductImageTransfer;
use Spryker\Client\Kernel\AbstractPlugin;

class GroupedImagesProductExpanderPlugin extends AbstractPlugin implements ProductExpanderPluginInterface
{
    /**
     * @param array $product
     * @param \Elastica\Result $document
     *
     * @return array
     */
    public function expand(array $product, Result $document): array
    {
        if (!isset($product[ProductImageGroupMapExpanderPlugin::KEY])) {
            return $product;
        }

        $groupedImages = [];

        foreach ($product[ProductImageGroupMapExpanderPlugin::KEY] as $key => $images) {
            $key = lcfirst(str_replace('_', '', ucwords($key, '_')));

            foreach ($images as $image) {
                $groupedImages[$key][] = (new RestCatalogSearchProductImageTransfer())->fromArray(
                    $image,
                    true,
                )->toArray(
                    true,
                    true,
                );
            }
        }

        $product[ProductImageGroupMapExpanderPlugin::KEY] = $groupedImages;

        return $product;
    }
}
