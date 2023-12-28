<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\Plugin\PublisherExtension;

use FondOfImpala\Zed\PriceProductPriceList\Dependency\PriceProductPriceListEvents;
use Orm\Zed\PriceProductPriceList\Persistence\Map\FoiPriceProductPriceListTableMap;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface;

/**
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\PriceProductPriceListPageSearchFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\PriceProductPriceListPageSearchCommunicationFactory getFactory()
 */
class PriceProductConcretePriceListDeletePublisherPlugin extends AbstractPlugin implements PublisherPluginInterface
{
    /**
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     * @param string $eventName
     *
     * @return void
     */
    public function handleBulk(array $eventEntityTransfers, $eventName): void
    {
        $productIds = $this->getFactory()
            ->getEventBehaviorFacade()
            ->getEventTransferForeignKeys($eventEntityTransfers, FoiPriceProductPriceListTableMap::COL_FK_PRODUCT);

        if (!$productIds) {
            return;
        }

        $this->getFacade()->publishConcretePriceProductByProductIds($productIds);
    }

    /**
     * @return array<string>
     */
    public function getSubscribedEvents(): array
    {
        return [
            PriceProductPriceListEvents::ENTITY_FOS_PRICE_PRODUCT_PRICE_LIST_DELETE,
        ];
    }
}
