<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper;

use Generated\Shared\Transfer\ErpOrderCancellationFilterSortTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationAttributesTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationFilterTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\Map\FoiErpOrderCancellationTableMap;

class RestFilterToFilterMapper implements RestFilterToFilterMapperInterface
{
    protected array $expanderPlugins;

    /**
     * @param \FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationRestFilterToFilterMapperExpanderPluginInterface[] $expanderPlugins
     */
    public function __construct(array $expanderPlugins)
    {
        $this->expanderPlugins = $expanderPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     * @param \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer|null $erpOrderCancellationFilterTransfer
     * @return \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer
     */
    public function fromRestRequest(RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer, ?ErpOrderCancellationFilterTransfer $erpOrderCancellationFilterTransfer = null): ErpOrderCancellationFilterTransfer
    {
        if ($erpOrderCancellationFilterTransfer === null) {
            $erpOrderCancellationFilterTransfer = new ErpOrderCancellationFilterTransfer();
        }

        $restErpOrderCancellationFilterTransfer = $restErpOrderCancellationRequestTransfer->getFilter();

        if ($restErpOrderCancellationFilterTransfer === null) {
            return $erpOrderCancellationFilterTransfer;
        }

        $erpOrderCancellationFilterTransfer->fromArray($restErpOrderCancellationFilterTransfer->toArray(), true);

        $erpOrderCancellationFilterTransfer = $this->handleAttributes($restErpOrderCancellationRequestTransfer->getAttributes(), $erpOrderCancellationFilterTransfer);
        $erpOrderCancellationFilterTransfer = $this->handlePagination($restErpOrderCancellationFilterTransfer, $erpOrderCancellationFilterTransfer);
        $erpOrderCancellationFilterTransfer = $this->handleSorting($restErpOrderCancellationFilterTransfer, $erpOrderCancellationFilterTransfer);

        foreach ($this->expanderPlugins as $expanderPlugin) {
            $erpOrderCancellationFilterTransfer = $expanderPlugin->expand($restErpOrderCancellationFilterTransfer, $erpOrderCancellationFilterTransfer);
        }

        return $erpOrderCancellationFilterTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationAttributesTransfer $attributes
     * @param \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer $erpOrderCancellationFilterTransfer
     * @return \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer
     */
    protected function handleAttributes(RestErpOrderCancellationAttributesTransfer $attributes, ErpOrderCancellationFilterTransfer $erpOrderCancellationFilterTransfer): ErpOrderCancellationFilterTransfer
    {
        if ($attributes->getUuid() !== null) {
            $erpOrderCancellationFilterTransfer->addId($attributes->getUuid());
        }

        return $erpOrderCancellationFilterTransfer->setOriginatorReference($attributes->getOriginatorReference());
    }

    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationFilterTransfer $restErpOrderCancellationFilterTransfer
     * @param \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer $erpOrderCancellationFilterTransfer
     * @return \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer
     */
    protected function handlePagination(RestErpOrderCancellationFilterTransfer $restErpOrderCancellationFilterTransfer, ErpOrderCancellationFilterTransfer $erpOrderCancellationFilterTransfer): ErpOrderCancellationFilterTransfer
    {
        $page = $restErpOrderCancellationFilterTransfer->getPage();
        if ($page !== null) {
            $erpOrderCancellationFilterTransfer
                ->setLimit($page->getLimit())
                ->setOffset($page->getOffset());
        }

        return $erpOrderCancellationFilterTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationFilterTransfer $restErpOrderCancellationFilterTransfer
     * @param \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer $erpOrderCancellationFilterTransfer
     * @return \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer
     */
    protected function handleSorting(RestErpOrderCancellationFilterTransfer $restErpOrderCancellationFilterTransfer, ErpOrderCancellationFilterTransfer $erpOrderCancellationFilterTransfer): ErpOrderCancellationFilterTransfer
    {
        $sorting = $restErpOrderCancellationFilterTransfer->getSort();
        if ($sorting->count() > 0) {
            foreach ($sorting as $sort) {
                $field = str_replace('-', '_', $sort->getField());
                if (in_array($field, FoiErpOrderCancellationTableMap::getFieldNames(FoiErpOrderCancellationTableMap::TYPE_FIELDNAME)) === false) {
                    continue;
                }
                $sort->setField($field);
                $erpOrderCancellationFilterTransfer->addSort((new ErpOrderCancellationFilterSortTransfer())->fromArray($sort->toArray(), true));
            }
        }

        return $erpOrderCancellationFilterTransfer;
    }
}
