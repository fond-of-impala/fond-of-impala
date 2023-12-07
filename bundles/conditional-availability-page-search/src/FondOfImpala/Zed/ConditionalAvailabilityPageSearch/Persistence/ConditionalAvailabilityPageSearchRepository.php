<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence;

use Generated\Shared\Transfer\FilterTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @codeCoverageIgnore
 *
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
        $foiConditionalAvailabilityPeriodPageSearchQuery = $this->getFactory()
            ->createConditionalAvailabilityPeriodPageSearchQuery();

        if ($conditionalAvailabilityIds) {
            $foiConditionalAvailabilityPeriodPageSearchQuery->filterByFkConditionalAvailability_In(
                $conditionalAvailabilityIds,
            );
        }

        return $this->buildQueryFromCriteria(
            $foiConditionalAvailabilityPeriodPageSearchQuery,
            $filterTransfer,
        )->find();
    }
}
