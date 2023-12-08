<?php

namespace FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Communication\Plugin\ProductPageSearch;

use Generated\Shared\Transfer\ProductPageSearchTransfer;
use Spryker\Shared\ProductPageSearch\ProductPageSearchConfig;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearchExtension\Dependency\Plugin\ProductPageDataExpanderPluginInterface;

/**
 * @method \Spryker\Zed\ProductPageSearch\Persistence\ProductPageSearchQueryContainerInterface getQueryContainer()
 * @method \Spryker\Zed\ProductPageSearch\Communication\ProductPageSearchCommunicationFactory getFactory()
 * @method \Spryker\Zed\ProductPageSearch\Business\ProductPageSearchFacadeInterface getFacade()
 * @method \Spryker\Zed\ProductPageSearch\ProductPageSearchConfig getConfig()
 */
class ProductImageGroupedPageDataLoaderExpanderPlugin extends AbstractPlugin implements ProductPageDataExpanderPluginInterface
{
    /**
     * @var string
     */
    protected const IMAGE_GROUP_NAME_EMPTY = '*';

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array<string, mixed> $productData
     * @param \Generated\Shared\Transfer\ProductPageSearchTransfer $productAbstractPageSearchTransfer
     *
     * @return void
     */
    public function expandProductPageData(array $productData, ProductPageSearchTransfer $productAbstractPageSearchTransfer)
    {
        /** @var \Generated\Shared\Transfer\ProductPayloadTransfer $productPayloadTransfer */
        $productPayloadTransfer = $productData[ProductPageSearchConfig::PRODUCT_ABSTRACT_PAGE_LOAD_DATA];
        $imageSets = $productPayloadTransfer->getImages();
        /** @var array<\Orm\Zed\ProductImage\Persistence\SpyProductImageSet> $imageSetsByLocale */
        $imageSetsByLocale = $imageSets[$productData['fk_locale']] ?? [];

        $productImages = $productAbstractPageSearchTransfer->getProductImages();

        $regrouped = [];

        foreach ($imageSetsByLocale as $imageSet) {
            foreach ($productImages as $productImage) {
                if ($productImage['fk_product_image_set'] === $imageSet->getIdProductImageSet()) {
                    $key = $imageSet->getName();

                    $regrouped[$key === null || $key === '' ? $key : static::IMAGE_GROUP_NAME_EMPTY][] = $productImage;
                }
            }
        }

        $productAbstractPageSearchTransfer->setGroupedProductImages($regrouped);
    }
}
