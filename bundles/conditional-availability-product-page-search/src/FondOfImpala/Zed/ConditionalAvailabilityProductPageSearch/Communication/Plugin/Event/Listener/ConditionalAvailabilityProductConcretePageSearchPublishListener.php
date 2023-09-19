<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication\Plugin\Event\Listener;

use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;
use Spryker\Zed\Event\Dependency\Plugin\EventBulkHandlerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication\ConditionalAvailabilityProductPageSearchCommunicationFactory getFactory()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\ConditionalAvailabilityProductPageSearchFacadeInterface getFacade()
 */
class ConditionalAvailabilityProductConcretePageSearchPublishListener extends AbstractPlugin implements EventBulkHandlerInterface
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
            ->getEventTransferIds($eventEntityTransfers);

        $conditionalAvailabilityCriteriaFilterTransfer = (new ConditionalAvailabilityCriteriaFilterTransfer())
            ->setIds($conditionalAvailabilityIds);

        $conditionalAvailabilityCollection = $this->getFactory()
            ->getConditionalAvailabilityFacade()
            ->findConditionalAvailabilities($conditionalAvailabilityCriteriaFilterTransfer);

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
