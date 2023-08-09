<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySearch\Communication\Plugin\Event\Listener;

use Spryker\Zed\Event\Dependency\Plugin\EventBulkHandlerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilitySearch\Communication\ConditionalAvailabilitySearchCommunicationFactory getFactory()
 * @method \FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\ConditionalAvailabilitySearchFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\ConditionalAvailabilitySearch\ConditionalAvailabilitySearchConfig getConfig()
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

        $conditionalAvailabilityCollection = $this->getFactory()
            ->getConditionalAvailabilityFacade()
            ->findConditionalAvailabilities($conditionalAvailabilityIds);

        if ($conditionalAvailabilityCollection->getConditionalAvailabilities()->count() === 0) {
            return;
        }

        $productConcreteIds = [];
        foreach ($conditionalAvailabilityCollection->getConditionalAvailabilities() as $conditionalAvailability) {
            $productConcreteIds[] = $conditionalAvailability->getFkProduct();
        }

        $this->getFactory()->getProductPageSearchFacade()->publishProductConcretes($productConcreteIds);
    }
}
