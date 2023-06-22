<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence;

use Generated\Shared\Transfer\FilterTransfer;

interface ConditionalAvailabilityPageSearchRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\FilterTransfer $filterTransfer
     * @param array $conditionalAvailabilityIds
     *
     * @return array<\Generated\Shared\Transfer\FoiConditionalAvailabilityPeriodPageSearchEntityTransfer>
     */
    public function findFilteredConditionalAvailabilityPeriodPageSearchEntities(
        FilterTransfer $filterTransfer,
        array $conditionalAvailabilityIds = []
    ): array;
}
