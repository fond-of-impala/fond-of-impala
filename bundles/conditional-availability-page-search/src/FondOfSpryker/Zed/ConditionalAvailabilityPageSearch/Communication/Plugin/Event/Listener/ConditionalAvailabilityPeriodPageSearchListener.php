<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication\Plugin\Event\Listener;

use FondOfImpala\Zed\ConditionalAvailability\Dependency\ConditionalAvailabilityEvents;
use Orm\Zed\ConditionalAvailability\Persistence\Map\FosConditionalAvailabilityPeriodTableMap;
use Spryker\Zed\Event\Dependency\Plugin\EventBulkHandlerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\PropelOrm\Business\Transaction\DatabaseTransactionHandlerTrait;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchConfig getConfig()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchQueryContainerInterface getQueryContainer()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\ConditionalAvailabilityPageSearchFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication\ConditionalAvailabilityPageSearchCommunicationFactory getFactory()
 */
class ConditionalAvailabilityPeriodPageSearchListener extends AbstractPlugin implements EventBulkHandlerInterface
{
    use DatabaseTransactionHandlerTrait;

    /**
     * @param array $eventTransfers
     * @param string $eventName
     *
     * @return void
     */
    public function handleBulk(array $eventTransfers, $eventName): void
    {
        $this->preventTransaction();

        $conditionalAvailabilityIds = $this->getFactory()
            ->getEventBehaviorFacade()
            ->getEventTransferForeignKeys(
                $eventTransfers,
                FosConditionalAvailabilityPeriodTableMap::COL_FK_CONDITIONAL_AVAILABILITY,
            );

        if (!$conditionalAvailabilityIds) {
            $conditionalAvailabilityIds = $this->getFactory()
                ->getEventBehaviorFacade()
                ->getEventTransferIds(
                    $eventTransfers,
                );
        }

        if (
            $eventName === ConditionalAvailabilityEvents::ENTITY_FOS_CONDITIONAL_AVAILABILITY_PERIOD_DELETE ||
            $eventName === ConditionalAvailabilityEvents::CONDITIONAL_AVAILABILITY_PERIOD_UNPUBLISH
        ) {
            $this->getFacade()->unpublish($conditionalAvailabilityIds);

            return;
        }

        $this->getFacade()->publish($conditionalAvailabilityIds);
    }
}
