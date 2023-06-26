<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence;

use Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer;
use Orm\Zed\ConditionalAvailabilityPageSearch\Persistence\FoiConditionalAvailabilityPeriodPageSearch;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchPersistenceFactory getFactory()
 */
class ConditionalAvailabilityPageSearchEntityManager extends AbstractEntityManager implements ConditionalAvailabilityPageSearchEntityManagerInterface
{
    /**
     * @param array $conditionalAvailabilityIds
     *
     * @return void
     */
    public function deleteConditionalAvailabilityPeriodSearchPagesByConditionalAvailabilityIds(
        array $conditionalAvailabilityIds
    ): void {
        $conditionalAvailabilityPeriodPageSearchEntities = $this->getFactory()
            ->createConditionalAvailabilityPeriodPageSearchQuery()
            ->filterByFkConditionalAvailability_In($conditionalAvailabilityIds)
            ->find();

        foreach ($conditionalAvailabilityPeriodPageSearchEntities as $conditionalAvailabilityPeriodPageSearchEntity) {
            $conditionalAvailabilityPeriodPageSearchEntity->delete();
        }
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
     *
     * @return void
     */
    public function createConditionalAvailabilityPeriodPageSearch(
        ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
    ): void {
        $FoiConditionalAvailabilityPeriodPageSearch = $this->getFactory()
            ->createConditionalAvailabilityPeriodPageSearchMapper()
            ->mapTransferToEntity(
                $conditionalAvailabilityPeriodPageSearchTransfer,
                new FoiConditionalAvailabilityPeriodPageSearch(),
            );

        $FoiConditionalAvailabilityPeriodPageSearch->save();
    }
}
