<?php

namespace FondOfImpala\Zed\CompanyCartSearchRestApi\Business;

use Generated\Shared\Transfer\QueryJoinCollectionTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\CompanyCartSearchRestApi\Business\CompanyCartSearchRestApiBusinessFactory getFactory()
 */
class CompanyCartSearchRestApiFacade extends AbstractFacade implements CompanyCartSearchRestApiFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array $filterFieldTransfers
     * @param \Generated\Shared\Transfer\QueryJoinCollectionTransfer $queryJoinCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\QueryJoinCollectionTransfer
     */
    public function expandQueryJoinCollection(
        array $filterFieldTransfers,
        QueryJoinCollectionTransfer $queryJoinCollectionTransfer
    ): QueryJoinCollectionTransfer {
        return $this->getFactory()
            ->createQueryJoinCollectionExpander()
            ->expand(
                $filterFieldTransfers,
                $queryJoinCollectionTransfer,
            );
    }
}
