<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchEntityManagerInterface getEntityManager()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\ConditionalAvailabilityPageSearchBusinessFactory getFactory()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchRepositoryInterface getRepository()
 */
class ConditionalAvailabilityPageSearchFacade extends AbstractFacade implements ConditionalAvailabilityPageSearchFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $eventName
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     *
     * @return void
     */
    public function publish(string $eventName, array $eventEntityTransfers): void
    {
        $this->getFactory()->createConditionalAvailabilityPeriodPageSearchPublisher()
            ->publish($eventName, $eventEntityTransfers);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $eventName
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     *
     * @return void
     */
    public function unpublish(string $eventName, array $eventEntityTransfers): void
    {
        $this->getFactory()->createConditionalAvailabilityPeriodPageSearchUnpublisher()
            ->unpublish($eventName, $eventEntityTransfers);
    }
}
