<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Communication\Plugin\Event\Listener;

use Orm\Zed\ProductList\Persistence\Map\SpyProductListProductConcreteTableMap;
use Spryker\Zed\Event\Dependency\Plugin\EventBulkHandlerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\PropelOrm\Business\Transaction\DatabaseTransactionHandlerTrait;

/**
 * @method \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Communication\ProductListPriceProductPriceListPageSearchCommunicationFactory getFactory()
 * @method \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\ProductListPriceProductPriceListPageSearchFacadeInterface getFacade()
 */
class ProductListPriceProductConcretePriceListPageSearchListener extends AbstractPlugin implements EventBulkHandlerInterface
{
    use DatabaseTransactionHandlerTrait;

    /**
     * @param array<\Spryker\Shared\Kernel\Transfer\TransferInterface> $transfers
     * @param string $eventName
     *
     * @return void
     */
    public function handleBulk(array $transfers, $eventName): void
    {
        $this->preventTransaction();

        $concreteProductIds = $this->getFactory()->getEventBehaviorFacade()
            ->getEventTransferForeignKeys($transfers, SpyProductListProductConcreteTableMap::COL_FK_PRODUCT);// @phpstan-ignore-line

        $this->getFactory()->getPriceProductPriceListPageSearchFacade()
            ->publishConcretePriceProductByProductIds($concreteProductIds);
    }
}
