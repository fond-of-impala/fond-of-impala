<?php

namespace FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\QueryContainer;

use Generated\Shared\Transfer\ApiQueryBuilderQueryTransfer;
use Generated\Shared\Transfer\PropelQueryBuilderCriteriaTransfer;
use Propel\Runtime\ActiveQuery\ModelCriteria;

interface ErpOrderCancellationApiToApiQueryBuilderQueryContainerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ApiQueryBuilderQueryTransfer $apiQueryBuilderQueryTransfer
     *
     * @return \Generated\Shared\Transfer\PropelQueryBuilderCriteriaTransfer
     */
    public function toPropelQueryBuilderCriteria(
        ApiQueryBuilderQueryTransfer $apiQueryBuilderQueryTransfer
    ): PropelQueryBuilderCriteriaTransfer;

    /**
     * @param \Propel\Runtime\ActiveQuery\ModelCriteria $query
     * @param \Generated\Shared\Transfer\ApiQueryBuilderQueryTransfer $apiQueryBuilderQueryTransfer
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    public function buildQueryFromRequest(
        ModelCriteria $query,
        ApiQueryBuilderQueryTransfer $apiQueryBuilderQueryTransfer
    ): ModelCriteria;
}
