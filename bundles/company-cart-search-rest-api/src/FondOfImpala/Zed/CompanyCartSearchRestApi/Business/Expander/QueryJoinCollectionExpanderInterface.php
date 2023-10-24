<?php

namespace FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Expander;

use Generated\Shared\Transfer\QueryJoinCollectionTransfer;

interface QueryJoinCollectionExpanderInterface
{
    /**
     * @param array $filterFieldTransfers
     * @param \Generated\Shared\Transfer\QueryJoinCollectionTransfer $queryJoinCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\QueryJoinCollectionTransfer
     */
    public function expand(
        array $filterFieldTransfers,
        QueryJoinCollectionTransfer $queryJoinCollectionTransfer
    ): QueryJoinCollectionTransfer;
}
