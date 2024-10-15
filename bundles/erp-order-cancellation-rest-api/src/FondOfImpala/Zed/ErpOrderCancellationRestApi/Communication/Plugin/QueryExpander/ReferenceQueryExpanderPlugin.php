<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\QueryExpander;

use FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationQueryExpanderPluginInterface;
use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery;

class ReferenceQueryExpanderPlugin implements ErpOrderCancellationQueryExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer $filterTransfer
     * @return bool
     */
    public function isApplicable(ErpOrderCancellationFilterTransfer $filterTransfer): bool
    {
        return count($filterTransfer->getReferences()) !== 0;
    }

    /**
     * @param \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery $query
     * @param \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer $filterTransfer
     *
     * @return \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery
     */
    public function expandErpOrderCancellationQuery(
        FoiErpOrderCancellationQuery       $query,
        ErpOrderCancellationFilterTransfer $filterTransfer
    ): FoiErpOrderCancellationQuery
    {
        return $query->filterByErpOrderReference_In($filterTransfer->getReferences());
    }
}
