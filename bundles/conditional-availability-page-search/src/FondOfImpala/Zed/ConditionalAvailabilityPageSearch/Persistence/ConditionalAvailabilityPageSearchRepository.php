<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence;

use Generated\Shared\Transfer\FilterTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchPersistenceFactory getFactory()
 */
class ConditionalAvailabilityPageSearchRepository extends AbstractRepository implements ConditionalAvailabilityPageSearchRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\FilterTransfer $filterTransfer
     * @param array<int> $conditionalAvailabilityIds
     *
     * @return array<\Generated\Shared\Transfer\FoiConditionalAvailabilityPeriodPageSearchEntityTransfer>
     */
    public function findFilteredConditionalAvailabilityPeriodPageSearchEntities(
        FilterTransfer $filterTransfer,
        array $conditionalAvailabilityIds = []
    ): array {
        $FoiConditionalAvailabilityPeriodPageSearchQuery = $this->getFactory()
            ->createConditionalAvailabilityPeriodPageSearchQuery();

        if ($conditionalAvailabilityIds) {
            $FoiConditionalAvailabilityPeriodPageSearchQuery->filterByFkConditionalAvailability_In(
                $conditionalAvailabilityIds,
            );
        }

        return $this->buildQueryFromCriteria(
            $FoiConditionalAvailabilityPeriodPageSearchQuery,
            $filterTransfer,
        )->find();
    }
}
