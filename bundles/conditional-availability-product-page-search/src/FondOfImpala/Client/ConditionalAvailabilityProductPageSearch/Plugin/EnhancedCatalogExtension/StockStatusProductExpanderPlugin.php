<?php

namespace FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\Plugin\EnhancedCatalogExtension;

use Elastica\Result;
use FondOfImpala\Client\EnhancedCatalogExtension\Dependency\Plugin\ProductExpanderPluginInterface;
use FondOfImpala\Shared\ConditionalAvailabilityProductPageSearch\ConditionalAvailabilityProductPageSearchConstants;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Client\Kernel\AbstractPlugin;

/**
 * @method \FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\ConditionalAvailabilityProductPageSearchFactory getFactory()
 */
class StockStatusProductExpanderPlugin extends AbstractPlugin implements ProductExpanderPluginInterface
{
    /**
     * @param array $product
     * @param \Elastica\Result $document
     *
     * @return array
     */
    public function expand(array $product, Result $document): array
    {
        if (!isset($product[ConditionalAvailabilityProductPageSearchConstants::SEARCH_KEY_STOCK_STATUS])) {
            $product['stock_status'] = 0;

            return $product;
        }

        $customerTransfer = $this->getCustomer();

        if (!$customerTransfer || !$customerTransfer->getAvailabilityChannel()) {
            $product['stock_status'] = 0;

            return $product;
        }

        $product['stock_status'] = $this->getStockStatus(
            $customerTransfer->getAvailabilityChannel(),
            $product[ConditionalAvailabilityProductPageSearchConstants::SEARCH_KEY_STOCK_STATUS],
        );

        return $product;
    }

    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    protected function getCustomer(): ?CustomerTransfer
    {
        return $this->getFactory()
            ->getCustomerClient()
            ->getCustomer();
    }

    /**
     * @param string $availabilityChannel
     * @param array<string> $stockStatuses
     *
     * @return int
     */
    protected function getStockStatus(string $availabilityChannel, array $stockStatuses): int
    {
        $search = $availabilityChannel . '-';
        foreach ($stockStatuses as $stockStatus) {
            $pos = strpos($stockStatus, $search);

            if ($pos !== false && $pos === 0) {
                 return (int)str_replace($search, '', $stockStatus);
            }
        }

        return 0;
    }
}
