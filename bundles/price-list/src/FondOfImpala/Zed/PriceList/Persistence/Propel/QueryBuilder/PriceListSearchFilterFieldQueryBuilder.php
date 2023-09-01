<?php

namespace FondOfImpala\Zed\PriceList\Persistence\Propel\QueryBuilder;

use FondOfImpala\Zed\PriceList\PriceListConfig;
use Generated\Shared\Transfer\FilterFieldTransfer;
use Generated\Shared\Transfer\PriceListListTransfer;
use Orm\Zed\PriceList\Persistence\Base\FoiPriceListQuery;
use Propel\Runtime\ActiveQuery\Criteria;

/**
 * @codeCoverageIgnore
 */
class PriceListSearchFilterFieldQueryBuilder implements PriceListSearchFilterFieldQueryBuilderInterface
{
    /**
     * @var string
     */
    protected const FILTER_FIELD_TYPE_ORDER_BY = 'orderBy';

    /**
     * @var string
     */
    protected const DELIMITER_ORDER_BY = '::';

    protected PriceListConfig $config;

    /**
     * @param \FondOfImpala\Zed\PriceList\PriceListConfig $config
     */
    public function __construct(PriceListConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param \Orm\Zed\PriceList\Persistence\Base\FoiPriceListQuery $priceListQuery
     * @param \Generated\Shared\Transfer\PriceListListTransfer $priceListListTransfer
     *
     * @return \Orm\Zed\PriceList\Persistence\Base\FoiPriceListQuery
     */
    public function addSalesOrderQueryFilters(
        FoiPriceListQuery $priceListQuery,
        PriceListListTransfer $priceListListTransfer
    ): FoiPriceListQuery {
        foreach ($priceListListTransfer->getFilterFields() as $filterFieldTransfer) {
            $priceListQuery = $this->addQueryFilter($priceListQuery, $filterFieldTransfer);
        }

        return $priceListQuery;
    }

    /**
     * @param \Orm\Zed\PriceList\Persistence\Base\FoiPriceListQuery $priceListQuery
     * @param \Generated\Shared\Transfer\FilterFieldTransfer $filterFieldTransfer
     *
     * @return \Orm\Zed\PriceList\Persistence\Base\FoiPriceListQuery
     */
    protected function addQueryFilter(
        FoiPriceListQuery $priceListQuery,
        FilterFieldTransfer $filterFieldTransfer
    ): FoiPriceListQuery {
        $filterFieldType = $filterFieldTransfer->getType();

        if (isset($this->config->getFilterFieldTypeMapping()[$filterFieldType])) {
            $priceListQuery->add(
                $this->config->getFilterFieldTypeMapping()[$filterFieldType],
                $filterFieldTransfer->getValue(),
                Criteria::EQUAL,
            );
        }

        if ($filterFieldType === static::FILTER_FIELD_TYPE_ORDER_BY) {
            return $this->addOrderByFilter(
                $priceListQuery,
                $filterFieldTransfer,
            );
        }

        return $priceListQuery;
    }

    /**
     * @param \Orm\Zed\PriceList\Persistence\Base\FoiPriceListQuery $salesOrderQuery
     * @param \Generated\Shared\Transfer\FilterFieldTransfer $filterFieldTransfer
     *
     * @return \Orm\Zed\PriceList\Persistence\Base\FoiPriceListQuery
     */
    protected function addOrderByFilter(
        FoiPriceListQuery $salesOrderQuery,
        FilterFieldTransfer $filterFieldTransfer
    ): FoiPriceListQuery {
        [$orderColumn, $orderDirection] = explode(static::DELIMITER_ORDER_BY, $filterFieldTransfer->getValue());

        if ($orderColumn) {
            $salesOrderQuery->orderBy($orderColumn, $orderDirection);
        }

        return $salesOrderQuery;
    }
}
