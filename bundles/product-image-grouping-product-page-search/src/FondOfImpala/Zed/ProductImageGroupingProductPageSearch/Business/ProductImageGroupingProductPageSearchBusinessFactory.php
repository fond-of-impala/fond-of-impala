<?php

namespace FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Business;

use FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Business\Expander\ProductImageGroupPageDataExpander;
use FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Business\Expander\ProductPageDataExpanderInterface;
use FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Business\Validator\UrlValidator;
use FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Business\Validator\UrlValidatorInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class ProductImageGroupingProductPageSearchBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Business\Expander\ProductPageDataExpanderInterface
     */
    public function createProductImageGroupPageDataExpander(): ProductPageDataExpanderInterface{
        return new ProductImageGroupPageDataExpander($this->createUrlValidator());
    }

    /**
     * @return \FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Business\Validator\UrlValidatorInterface
     */
    public function createUrlValidator(): UrlValidatorInterface{
        return new UrlValidator();
    }
}
