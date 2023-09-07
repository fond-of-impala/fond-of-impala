<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySearch\Communication\Plugin\Event\Listener;

use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;
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

        $this->getFactory()->getProductPageSearchFacade()->publishProductConcretes($productConcreteIds);

        $productAbstractIds = $this->getFacade()->getProductAbstractIdsByConcreteIds($productConcreteIds);

        $this->getFactory()->getProductPageSearchFacade()->publish($productAbstractIds);
    }
}
