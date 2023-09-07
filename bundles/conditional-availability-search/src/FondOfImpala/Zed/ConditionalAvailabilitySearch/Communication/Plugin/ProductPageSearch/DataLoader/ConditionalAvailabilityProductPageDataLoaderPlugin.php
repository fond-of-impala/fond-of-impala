<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySearch\Communication\Plugin\ProductPageSearch\DataLoader;

use Generated\Shared\Transfer\ProductPageLoadTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearchExtension\Dependency\Plugin\ProductPageDataLoaderPluginInterface;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\ConditionalAvailabilitySearchFacadeInterface getFacade()
 */
class ConditionalAvailabilityProductPageDataLoaderPlugin extends AbstractPlugin implements ProductPageDataLoaderPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductPageLoadTransfer $productPageLoadTransfer
     *
     * @return \Generated\Shared\Transfer\ProductPageLoadTransfer
     */
    public function expandProductPageDataTransfer(ProductPageLoadTransfer $productPageLoadTransfer)
    {
        return $this->getFacade()->expandProductPageData($productPageLoadTransfer);
    }
}
