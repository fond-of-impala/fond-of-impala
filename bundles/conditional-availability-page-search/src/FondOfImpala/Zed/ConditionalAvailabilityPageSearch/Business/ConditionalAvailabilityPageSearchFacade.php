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

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array<string> $keys
     *
     * @return void
     */
    public function publishByKeys(array $keys): void
    {
        $this->getFactory()->createConditionalAvailabilityPeriodPageSearchPublisher()
            ->publishByKeys($keys);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array<int> $conditionalAvailabilityIds
     *
     * @return void
     */
    public function publishByConditionalAvailabilityIds(array $conditionalAvailabilityIds): void
    {
        $this->getFactory()->createConditionalAvailabilityPeriodPageSearchPublisher()
            ->publishByConditionalAvailabilityIds($conditionalAvailabilityIds);
    }
}
