<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Communication\Plugin\Event\Listener;

use FondOfImpala\Shared\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchConstants;
use Orm\Zed\ProductList\Persistence\Map\SpyProductListProductConcreteTableMap;
use Spryker\Zed\Event\Dependency\Plugin\EventBulkHandlerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\PropelOrm\Business\Transaction\DatabaseTransactionHandlerTrait;

/**
 * @method \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\ProductListConditionalAvailabilityPageSearchFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Communication\ProductListConditionalAvailabilityPageSearchCommunicationFactory getFactory()
 */
class ProductListProductConcreteListener extends AbstractPlugin implements EventBulkHandlerInterface
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

        $concreteIds = $this->getFactory()->getEventBehaviorFacade()
            ->getEventTransferForeignKeys($eventEntityTransfers, SpyProductListProductConcreteTableMap::COL_FK_PRODUCT);

        $conditionalAvailabilityIds = $this->getFactory()->getConditionalAvailabilityFacade()
            ->getConditionalAvailabilityIdsByProductConcreteIds($concreteIds);

        $this->getFactory()->getEventBehaviorFacade()->executeResolvedPluginsBySources(
            [ConditionalAvailabilityPageSearchConstants::CONDITIONAL_AVAILABILITY_PERIOD_RESOURCE_NAME],
            $conditionalAvailabilityIds,
        );
    }
}
