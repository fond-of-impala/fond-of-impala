<?php

namespace FondOfImpala\Zed\AllowedProductQuantitySearch\Communication\Plugin\Event\Listener;

use FondOfImpala\Zed\AllowedProductQuantitySearch\AllowedProductQuantitySearchConfig;
use Orm\Zed\AllowedProductQuantity\Persistence\Map\FoiAllowedProductQuantityTableMap;
use Spryker\Zed\Event\Dependency\Plugin\EventBulkHandlerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\PropelOrm\Business\Transaction\DatabaseTransactionHandlerTrait;

/**
 * @method \FondOfImpala\Zed\AllowedProductQuantitySearch\AllowedProductQuantitySearchConfig getConfig()
 * @method \FondOfImpala\Zed\AllowedProductQuantitySearch\Communication\AllowedProductQuantitySearchCommunicationFactory getFactory()
 * @method \FondOfImpala\Zed\AllowedProductQuantitySearch\Business\AllowedProductQuantitySearchFacadeInterface getFacade()
 */
class AllowedProductQuantitySearchListener extends AbstractPlugin implements EventBulkHandlerInterface
{
    use DatabaseTransactionHandlerTrait;

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $transfers $transfers
     * @param string $eventName
     *
     * @return void
     */
    public function handleBulk(array $transfers, $eventName): void
    {
        $this->preventTransaction();
        $productAbstractIds = $this->getFactory()->getEventBehaviorFacade()
            ->getEventTransferForeignKeys(
                $transfers,
                FoiAllowedProductQuantityTableMap::COL_FK_PRODUCT_ABSTRACT,
            );

        $this->getFactory()->getProductPageSearchFacade()
            ->refresh(
                $productAbstractIds,
                [AllowedProductQuantitySearchConfig::PLUGIN_PRODUCT_ALLOWED_QUANTITY_PAGE_DATA],
            );
    }
}
