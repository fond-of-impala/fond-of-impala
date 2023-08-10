<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\Plugin\Event;

use FondOfImpala\Shared\PriceProductPriceListPageSearch\PriceProductPriceListPageSearchConstants;
use FondOfImpala\Zed\PriceProductPriceList\Dependency\PriceProductPriceListEvents;
use Orm\Zed\PriceProductPriceList\Persistence\Map\FoiPriceProductPriceListTableMap;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Spryker\Zed\EventBehavior\Dependency\Plugin\EventResourceQueryContainerPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\PriceProductPriceListPageSearchConfig getConfig()
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\PriceProductPriceListPageSearchFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\PriceProductPriceListPageSearchCommunicationFactory getFactory()
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchQueryContainerInterface getQueryContainer()
 */
class PriceProductAbstractPriceListPageSearchEventResourceQueryContainerPlugin extends AbstractPlugin implements EventResourceQueryContainerPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getResourceName(): string
    {
        return PriceProductPriceListPageSearchConstants::PRICE_PRODUCT_ABSTRACT_PRICE_LIST_RESOURCE_NAME;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getEventName(): string
    {
        return PriceProductPriceListEvents::PRICE_PRODUCT_ABSTRACT_PRICE_LIST_PUBLISH;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string|null
     */
    public function getIdColumnName(): ?string
    {
        return FoiPriceProductPriceListTableMap::COL_ID_PRICE_PRODUCT_PRICE_LIST;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int[] $ids
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria|null
     */
    public function queryData(array $ids = []): ?ModelCriteria
    {
        return $this->getQueryContainer()->queryPriceProductAbstractPriceList($ids);
    }
}
