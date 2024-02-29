<?php

namespace FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Business\Expander;

use FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Business\Validator\UrlValidatorInterface;
use Generated\Shared\Transfer\ProductPageSearchTransfer;
use Spryker\Shared\ProductPageSearch\ProductPageSearchConfig;

class ProductImageGroupPageDataExpander implements ProductPageDataExpanderInterface
{
    /**
     * @var string
     */
    protected const IMAGE_GROUP_NAME_EMPTY = '*';

    /**
     * @var string
     */
    protected const EXTERNAL_URL_PREFIX = 'external_url';

    protected UrlValidatorInterface $urlValidator;

    /**
     * @param \FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Business\Validator\UrlValidatorInterface $urlValidator
     */
    public function __construct(UrlValidatorInterface $urlValidator)
    {
        $this->urlValidator = $urlValidator;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array<string, mixed> $productData
     * @param \Generated\Shared\Transfer\ProductPageSearchTransfer $productAbstractPageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\ProductPageSearchTransfer
     */
    public function expandProductPageData(array $productData, ProductPageSearchTransfer $productAbstractPageSearchTransfer): ProductPageSearchTransfer
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
                    $productImage = $this->validateProductImageUrls($productImage);
                    if ($productImage === null) {
                        continue;
                    }
                    $regrouped[$key === null || $key === '' ? static::IMAGE_GROUP_NAME_EMPTY : $key][] = $productImage;
                }
            }
        }

        return $productAbstractPageSearchTransfer->setGroupedProductImages($regrouped);
    }

    /**
     * @param array $productImage
     *
     * @return array|null
     */
    protected function validateProductImageUrls(array $productImage): ?array
    {
        foreach ($productImage as $key => $data) {
            if (str_starts_with($key, static::EXTERNAL_URL_PREFIX) && ($data === null || !$this->urlValidator->isValid($data))) {
                    return null;
            }
        }

        return $productImage;
    }
}
