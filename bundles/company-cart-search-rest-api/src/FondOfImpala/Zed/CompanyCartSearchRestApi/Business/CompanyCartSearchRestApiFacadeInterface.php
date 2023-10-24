<?php

namespace FondOfImpala\Zed\CompanyCartSearchRestApi\Business;

use Generated\Shared\Transfer\QueryJoinCollectionTransfer;

interface CompanyCartSearchRestApiFacadeInterface
{
    /**
     * @param array $filterFieldTransfers
     * @param \Generated\Shared\Transfer\QueryJoinCollectionTransfer $queryJoinCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\QueryJoinCollectionTransfer
     */
    public function expandQueryJoinCollection(
        array $filterFieldTransfers,
        QueryJoinCollectionTransfer $queryJoinCollectionTransfer
    ): QueryJoinCollectionTransfer;
}
