<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication\Plugin\Event\Listener;

use Orm\Zed\ConditionalAvailability\Persistence\Map\FoiConditionalAvailabilityPeriodTableMap;
use Spryker\Zed\Event\Dependency\Plugin\EventBulkHandlerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication\ConditionalAvailabilityProductPageSearchCommunicationFactory getFactory()
 */
class ConditionalAvailabilityProductPageSearchPublishListener extends AbstractPlugin implements EventBulkHandlerInterface
{
    /**
     * {@inheritDoc}
     * - Handles stock status update event.
     *
     * @api
     *
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     * @param string $eventName
     *
     * @return void
     */
    public function handleBulk(array $eventEntityTransfers, $eventName): void
    {
        $conditionalAvailabilityIds = $this->getFactory()
            ->getEventBehaviorFacade()
            ->getEventTransferForeignKeys(
                $eventEntityTransfers,
                FoiConditionalAvailabilityPeriodTableMap::COL_FK_CONDITIONAL_AVAILABILITY,
            );

        $conditionalAvailabilityCollection = $this->getFactory()
            ->getConditionalAvailabilityFacade()
            ->getConditionalAvailabilitiesByIds($conditionalAvailabilityIds);

        if ($conditionalAvailabilityCollection->getConditionalAvailabilities()->count() === 0) {
            return;
        }

        $productConcreteIds = [];
        foreach ($conditionalAvailabilityCollection->getConditionalAvailabilities() as $conditionalAvailability) {
            $productConcreteIds[] = $conditionalAvailability->getFkProduct();
        }

        $this->publishProductConcretes($productConcreteIds);
        $this->publishProductAbstracts($productConcreteIds);
    }

    /**
     * @param array<int> $productConcreteIds
     *
     * @return void
     */
    protected function publishProductConcretes(array $productConcreteIds): void
    {
        $this->getFactory()->getProductPageSearchFacade()->publishProductConcretes($productConcreteIds);
    }

    /**
     * @param array<int> $productConcreteIds
     *
     * @return void
     */
    protected function publishProductAbstracts(array $productConcreteIds): void
    {
        $productAbstractIds = $this->getFactory()
            ->createProductAbstractReader()
            ->getProductAbstractIdsByConcreteIds($productConcreteIds);

        $this->getFactory()->getProductPageSearchFacade()->publish($productAbstractIds);
    }
}
