<?php

namespace FondOfImpala\Zed\PermissionCartSearchRestApi\Communication\Plugin\CartSearchRestApiExtension;

use FondOfImpala\Zed\PermissionCartSearchRestApi\Communication\Plugin\PermissionExtension\SearchCartPermissionPlugin;
use FondOfOryx\Zed\CartSearchRestApiExtension\Dependency\Plugin\SearchQuoteQueryExpanderPluginInterface;
use Generated\Shared\Transfer\QueryJoinCollectionTransfer;
use Generated\Shared\Transfer\QueryJoinTransfer;
use Generated\Shared\Transfer\QueryWhereConditionTransfer;
use Orm\Zed\CompanyRole\Persistence\Map\SpyCompanyRoleToCompanyUserTableMap;
use Orm\Zed\CompanyRole\Persistence\Map\SpyCompanyRoleToPermissionTableMap;
use Orm\Zed\CompanyUser\Persistence\Map\SpyCompanyUserTableMap;
use Orm\Zed\Quote\Persistence\Map\SpyQuoteTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\PermissionCartSearchRestApi\Persistence\PermissionCartSearchRestApiRepositoryInterface getRepository()
 */
class PermissionSearchQuoteQueryExpanderPlugin extends AbstractPlugin implements SearchQuoteQueryExpanderPluginInterface
{
    /**
     * @param array<\Generated\Shared\Transfer\FilterFieldTransfer> $filterFieldTransfers
     *
     * @return bool
     */
    public function isApplicable(array $filterFieldTransfers): bool
    {
        return true;
    }

    /**
     * @param array<\Generated\Shared\Transfer\FilterFieldTransfer> $filterFieldTransfers
     * @param \Generated\Shared\Transfer\QueryJoinCollectionTransfer $queryJoinCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\QueryJoinCollectionTransfer
     */
    public function expand(
        array $filterFieldTransfers,
        QueryJoinCollectionTransfer $queryJoinCollectionTransfer
    ): QueryJoinCollectionTransfer {
        $idPermission = $this->getRepository()->getIdPermissionByKey(SearchCartPermissionPlugin::KEY);

        if ($idPermission === null) {
            return $queryJoinCollectionTransfer;
        }

        return $queryJoinCollectionTransfer->addQueryJoin(
            (new QueryJoinTransfer())
                ->setJoinType(Criteria::INNER_JOIN)
                ->setLeft([SpyQuoteTableMap::COL_COMPANY_USER_REFERENCE])
                ->setRight([SpyCompanyUserTableMap::COL_COMPANY_USER_REFERENCE]),
        )->addQueryJoin(
            (new QueryJoinTransfer())
                ->setJoinType(Criteria::INNER_JOIN)
                ->setLeft([SpyCompanyUserTableMap::COL_ID_COMPANY_USER])
                ->setRight([SpyCompanyRoleToCompanyUserTableMap::COL_FK_COMPANY_USER]),
        )->addQueryJoin(
            (new QueryJoinTransfer())
                ->setJoinType(Criteria::INNER_JOIN)
                ->setLeft([SpyCompanyRoleToCompanyUserTableMap::COL_FK_COMPANY_ROLE])
                ->setRight([SpyCompanyRoleToPermissionTableMap::COL_FK_COMPANY_ROLE])
                ->addQueryWhereCondition(
                    (new QueryWhereConditionTransfer())
                        ->setValue((string)$idPermission)
                        ->setColumn(SpyCompanyRoleToPermissionTableMap::COL_FK_PERMISSION)
                        ->setComparison(Criteria::EQUAL),
                ),
        );
    }
}
