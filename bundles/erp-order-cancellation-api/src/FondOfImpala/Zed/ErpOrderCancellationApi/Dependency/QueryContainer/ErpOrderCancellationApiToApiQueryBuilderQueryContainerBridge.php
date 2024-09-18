<?php

namespace FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\QueryContainer;

use Generated\Shared\Transfer\ApiQueryBuilderQueryTransfer;
use Generated\Shared\Transfer\PropelQueryBuilderCriteriaTransfer;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Spryker\Zed\ApiQueryBuilder\Persistence\ApiQueryBuilderQueryContainerInterface;

class ErpOrderCancellationApiToApiQueryBuilderQueryContainerBridge implements ErpOrderCancellationApiToApiQueryBuilderQueryContainerInterface
{
    /**
     * @var \Spryker\Zed\ApiQueryBuilder\Persistence\ApiQueryBuilderQueryContainerInterface
     */
    protected $apiQueryBuilderQueryContainer;

    /**
     * @param \Spryker\Zed\ApiQueryBuilder\Persistence\ApiQueryBuilderQueryContainerInterface $apiQueryBuilderQueryContainer
     */
    public function __construct(ApiQueryBuilderQueryContainerInterface $apiQueryBuilderQueryContainer)
    {
        $this->apiQueryBuilderQueryContainer = $apiQueryBuilderQueryContainer;
    }

    /**
     * @param \Generated\Shared\Transfer\ApiQueryBuilderQueryTransfer $apiQueryBuilderQueryTransfer
     *
     * @return \Generated\Shared\Transfer\PropelQueryBuilderCriteriaTransfer
     */
    public function toPropelQueryBuilderCriteria(
        ApiQueryBuilderQueryTransfer $apiQueryBuilderQueryTransfer
    ): PropelQueryBuilderCriteriaTransfer {
        return $this->apiQueryBuilderQueryContainer->toPropelQueryBuilderCriteria($apiQueryBuilderQueryTransfer);
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\ModelCriteria $query
     * @param \Generated\Shared\Transfer\ApiQueryBuilderQueryTransfer $apiQueryBuilderQueryTransfer
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    public function buildQueryFromRequest(
        ModelCriteria $query,
        ApiQueryBuilderQueryTransfer $apiQueryBuilderQueryTransfer
    ): ModelCriteria {
        return $this->apiQueryBuilderQueryContainer->buildQueryFromRequest($query, $apiQueryBuilderQueryTransfer);
    }
}
