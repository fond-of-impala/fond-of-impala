<?php

namespace FondOfImpala\Client\EnhancedCatalog\Plugin\ResultFormatter;

use Elastica\ResultSet;
use Spryker\Client\SearchElasticsearch\Plugin\ResultFormatter\AbstractElasticsearchResultFormatterPlugin;

/**
 * @method \FondOfImpala\Client\EnhancedCatalog\EnhancedCatalogFactory getFactory()
 */
class RawCatalogSearchResultFormatterPlugin extends AbstractElasticsearchResultFormatterPlugin
{
    /**
     * @var string
     */
    public const NAME = 'products';

    /**
     * @return string
     */
    public function getName()
    {
        return static::NAME;
    }

    /**
     * @param \Elastica\ResultSet $searchResult
     * @param array<string, mixed> $requestParameters
     *
     * @return mixed
     */
    protected function formatSearchResult(ResultSet $searchResult, array $requestParameters)
    {
        return $this->getFactory()
            ->createRawCatalogSearchResultFormatter()
            ->format(
                $searchResult,
                $requestParameters,
            );
    }
}
