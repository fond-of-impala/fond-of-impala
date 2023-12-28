<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\Plugin\PublisherExtension;

use FondOfImpala\Zed\PriceProductPriceList\Dependency\PriceProductPriceListEvents;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface;

/**
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\PriceProductPriceListPageSearchFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\PriceProductPriceListPageSearchCommunicationFactory getFactory()
 */
class PriceProductAbstractPriceListWritePublisherPlugin extends AbstractPlugin implements PublisherPluginInterface
{
    /**
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     * @param string $eventName
     *
     * @return void
     */
    public function handleBulk(array $eventEntityTransfers, $eventName): void
    {
        $eventTransferIds = $this->getFactory()
            ->getEventBehaviorFacade()
            ->getEventTransferIds($eventEntityTransfers);

        $this->getFacade()->publishAbstractPriceProductPriceList($eventTransferIds);
    }

    /**
     * @return array<string>
     */
    public function getSubscribedEvents(): array
    {
        return [
            PriceProductPriceListEvents::PRICE_PRODUCT_ABSTRACT_PRICE_LIST_PUBLISH,
            PriceProductPriceListEvents::ENTITY_FOS_PRICE_PRODUCT_PRICE_LIST_CREATE,
            PriceProductPriceListEvents::ENTITY_FOS_PRICE_PRODUCT_PRICE_LIST_UPDATE,
        ];
    }
}
