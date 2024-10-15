<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin;

use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery;

interface ErpOrderCancellationQueryExpanderPluginInterface
{
    /**
     * @param \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery $query
     * @param \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer $filterTransfer
     *
     * @return \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery
     */
    public function expandErpOrderCancellationQuery(
        FoiErpOrderCancellationQuery $query,
        ErpOrderCancellationFilterTransfer $filterTransfer
    ): FoiErpOrderCancellationQuery;
}
