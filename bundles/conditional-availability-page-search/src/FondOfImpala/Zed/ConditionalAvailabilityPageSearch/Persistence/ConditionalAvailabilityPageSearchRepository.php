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
     * @return array<\Generated\Shared\Transfer\FosConditionalAvailabilityPeriodPageSearchEntityTransfer>
     */
    public function findFilteredConditionalAvailabilityPeriodPageSearchEntities(
        FilterTransfer $filterTransfer,
        array $conditionalAvailabilityIds = []
    ): array {
        $fosConditionalAvailabilityPeriodPageSearchQuery = $this->getFactory()
            ->createConditionalAvailabilityPeriodPageSearchQuery();

        if ($conditionalAvailabilityIds) {
            $fosConditionalAvailabilityPeriodPageSearchQuery->filterByFkConditionalAvailability_In(
                $conditionalAvailabilityIds,
            );
        }

        return $this->buildQueryFromCriteria(
            $fosConditionalAvailabilityPeriodPageSearchQuery,
            $filterTransfer,
        )->find();
    }
}
