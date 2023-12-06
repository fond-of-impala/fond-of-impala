<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication\Plugin\Event\Listener;

use FondOfImpala\Zed\ConditionalAvailability\Dependency\ConditionalAvailabilityEvents;
use Spryker\Zed\Event\Dependency\Plugin\EventBulkHandlerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\PropelOrm\Business\Transaction\DatabaseTransactionHandlerTrait;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchConfig getConfig()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchQueryContainerInterface getQueryContainer()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\ConditionalAvailabilityPageSearchFacadeInterface getFacade()
 */
class ConditionalAvailabilityPeriodPageSearchListener extends AbstractPlugin implements EventBulkHandlerInterface
{
    use DatabaseTransactionHandlerTrait;

    /**
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     * @param string $eventName
     *
     * @return void
     */
    public function handleBulk(array $eventEntityTransfers, $eventName): void
    {
        $this->preventTransaction();

        if (
            $eventName === ConditionalAvailabilityEvents::ENTITY_FOI_CONDITIONAL_AVAILABILITY_PERIOD_DELETE ||
            $eventName === ConditionalAvailabilityEvents::CONDITIONAL_AVAILABILITY_PERIOD_UNPUBLISH
        ) {
            $this->getFacade()->unpublish($eventName, $eventEntityTransfers);

            return;
        }

        $this->getFacade()->publish($eventName, $eventEntityTransfers);
    }
}
