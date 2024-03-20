<?php

namespace FondOfImpala\Client\EnhancedCatalog\Formatter;

use Elastica\ResultSet;

interface RawCatalogSearchResultFormatterInterface
{
    /**
     * @param \Elastica\ResultSet $searchResult
     * @param array<string, mixed> $requestParameters
     *
     * @return mixed
     */
    public function format(ResultSet $searchResult, array $requestParameters);
}
