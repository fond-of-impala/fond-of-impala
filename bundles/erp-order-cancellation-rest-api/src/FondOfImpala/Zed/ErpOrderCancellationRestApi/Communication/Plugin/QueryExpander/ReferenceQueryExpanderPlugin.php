<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\QueryExpander;

use FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationQueryExpanderPluginInterface;
use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery;

class ReferenceQueryExpanderPlugin implements ErpOrderCancellationQueryExpanderPluginInterface
{
    public function expandErpOrderCancellationQuery(FoiErpOrderCancellationQuery $query, ErpOrderCancellationFilterTransfer $filterTransfer): FoiErpOrderCancellationQuery
    {
        if (count($filterTransfer->getReferences()) === 0) {
            return $query;
        }

        return $query->filterByErpOrderReference_In($filterTransfer->getReferences());
    }


}
