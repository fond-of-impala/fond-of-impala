<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence;

use Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchPersistenceFactory getFactory()
 */
class ConditionalAvailabilityPageSearchEntityManager extends AbstractEntityManager implements ConditionalAvailabilityPageSearchEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
     *
     * @return void
     */
    public function persistConditionalAvailabilityPeriodPageSearch(
        ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
    ): void {
        $conditionalAvailabilityPeriodKey = $conditionalAvailabilityPeriodPageSearchTransfer->getConditionalAvailabilityPeriodKey();

        $conditionalAvailabilityPeriodPageSearch = $this->getFactory()->createConditionalAvailabilityPeriodPageSearchQuery()
            ->filterByConditionalAvailabilityPeriodKey($conditionalAvailabilityPeriodKey)
            ->findOneOrCreate();

        $foiConditionalAvailabilityPeriodPageSearch = $this->getFactory()
            ->createConditionalAvailabilityPeriodPageSearchMapper()
            ->mapTransferToEntity(
                $conditionalAvailabilityPeriodPageSearchTransfer,
                $conditionalAvailabilityPeriodPageSearch,
            );

        $foiConditionalAvailabilityPeriodPageSearch->save();
    }

    /**
     * @param array<int> $conditionalAvailabilityIds
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
     * @param array<string> $keys
     *
     * @return void
     */
    public function deleteConditionalAvailabilityPeriodSearchPagesByKeys(array $keys): void
    {
        $conditionalAvailabilityPeriodPageSearchEntities = $this->getFactory()
            ->createConditionalAvailabilityPeriodPageSearchQuery()
            ->filterByConditionalAvailabilityPeriodKey_In($keys)
            ->find();

        foreach ($conditionalAvailabilityPeriodPageSearchEntities as $conditionalAvailabilityPeriodPageSearchEntity) {
            $conditionalAvailabilityPeriodPageSearchEntity->delete();
        }
    }
}
