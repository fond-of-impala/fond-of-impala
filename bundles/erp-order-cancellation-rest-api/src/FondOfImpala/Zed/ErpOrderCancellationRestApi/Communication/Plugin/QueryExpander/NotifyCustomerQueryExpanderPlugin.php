<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\QueryExpander;

use FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationQueryExpanderPluginInterface;
use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery;
use Propel\Runtime\ActiveQuery\Criteria;

class NotifyCustomerQueryExpanderPlugin implements ErpOrderCancellationQueryExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer $filterTransfer
     *
     * @return bool
     */
    public function isApplicable(ErpOrderCancellationFilterTransfer $filterTransfer): bool
    {
        return $filterTransfer->getFkCustomer() !== null;
    }

    /**
     * @param \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery $query
     * @param \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer $filterTransfer
     *
     * @return \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery
     */
    public function expandErpOrderCancellationQuery(
        FoiErpOrderCancellationQuery $query,
        ErpOrderCancellationFilterTransfer $filterTransfer
    ): FoiErpOrderCancellationQuery {
        return $query
            ->joinFoiErpOrderCancellationNotify()
            ->useFoiErpOrderCancellationNotifyQuery()
            ->filterByFkCustomer($filterTransfer->getFkCustomer(), Criteria::EQUAL)
            ->endUse();
    }
}
