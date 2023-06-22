<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Processor\ConditionalAvailabilityPageSearch\Mapper;

use Generated\Shared\Transfer\RestConditionalAvailabilityPageSearchCollectionResponseTransfer;

interface ConditionalAvailabilityPageSearchMapperInterface
{
    /**
     * @param array $searchResult
     *
     * @return \Generated\Shared\Transfer\RestConditionalAvailabilityPageSearchCollectionResponseTransfer
     */
    public function mapSearchResultToRestConditionalAvailabilityPageSearchCollectionResponseTransfer(
        array $searchResult
    ): RestConditionalAvailabilityPageSearchCollectionResponseTransfer;
}
