<?php

namespace FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\Plugin\SearchExtension;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\FacetConfigTransfer;
use Generated\Shared\Transfer\FacetSearchResultTransfer;
use Generated\Shared\Transfer\FacetSearchResultValueTransfer;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\SearchExtension\Dependency\Plugin\ResultFormatterPluginInterface;

/**
 * @method \FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\ConditionalAvailabilityProductPageSearchFactory getFactory()
 */
class StockStatusResultFormatterPlugin extends AbstractPlugin implements ResultFormatterPluginInterface
{
    /**
     * @var string
     */
    protected const STOCK_STATUS_KEY = 'stock-status';

    /**
     * {@inheritDoc}
     * - Formats stock-status
     *
     * @api
     *
     * @param \Elastica\ResultSet $searchResult
     * @param array<mixed> $requestParameters
     *
     * @return mixed
     */
    public function formatResult($searchResult, array $requestParameters = [])
    {
        $result = [];
        $stockStatusAggregation = $searchResult->getAggregation(static::STOCK_STATUS_KEY);

        if (!$stockStatusAggregation) {
                    return $result;
        }

        $customerTransfer = $this->getCustomer();

        if (!$customerTransfer || !$customerTransfer->getAvailabilityChannel()) {
                return $result;
        }

        $stockStatusFacetSearchResultTransfer = (new FacetSearchResultTransfer())
            ->setName(static::STOCK_STATUS_KEY)
            ->setConfig(new FacetConfigTransfer());

        foreach ($stockStatusAggregation['buckets'] as $bucket) {
            $bucketKeyParts = explode('-', $bucket['key']);

            if ($bucketKeyParts[0] !== $customerTransfer->getAvailabilityChannel()) {
                continue;
            }

             $stockStatusFacetSearchResultTransfer->addValue(
                 $this->getFacetSearchValueTransfer(end($bucketKeyParts), $bucket['doc_count']),
             );
        }

        $result[static::STOCK_STATUS_KEY] = $stockStatusFacetSearchResultTransfer;

        return $result;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'facets';
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
     * @param string $value
     * @param int $docCount
     *
     * @return \Generated\Shared\Transfer\FacetSearchResultValueTransfer
     */
    protected function getFacetSearchValueTransfer(string $value, int $docCount): FacetSearchResultValueTransfer
    {
        return (new FacetSearchResultValueTransfer())
            ->setValue($value)
            ->setDocCount($docCount);
    }
}
