<?php

namespace FondOfImpala\Zed\CompanyCartSearchRestApi\Communication\Plugin\CartSearchRestApiExtension;

use FondOfImpala\Shared\CompanyCartSearchRestApi\CompanyCartSearchRestApiConstants;
use FondOfImpala\Zed\CompanyCartSearchRestApi\Communication\Plugin\PermissionExtension\SearchCartPermissionPlugin;
use FondOfOryx\Zed\CartSearchRestApiExtension\Dependency\Plugin\SearchQuoteQueryExpanderPluginInterface;
use Generated\Shared\Transfer\QueryJoinCollectionTransfer;
use Generated\Shared\Transfer\QueryJoinTransfer;
use Generated\Shared\Transfer\QueryWhereConditionTransfer;
use Orm\Zed\CompanyRole\Persistence\Map\SpyCompanyRoleToCompanyUserTableMap;
use Orm\Zed\CompanyRole\Persistence\Map\SpyCompanyRoleToPermissionTableMap;
use Orm\Zed\CompanyUser\Persistence\Map\SpyCompanyUserTableMap;
use Orm\Zed\Customer\Persistence\Map\SpyCustomerTableMap;
use Orm\Zed\Quote\Persistence\Map\SpyQuoteTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CompanyCartSearchRestApi\Persistence\CompanyCartSearchRestApiRepositoryInterface getRepository()
 */
class CustomerSearchQuoteQueryExpanderPlugin extends AbstractPlugin implements SearchQuoteQueryExpanderPluginInterface
{
    /**
     * @var string
     */
    protected const REQUIRED_FILTER_FIELD_TYPE = CompanyCartSearchRestApiConstants::FILTER_FIELD_TYPE_ID_CUSTOMER;

    /**
     * @var string
     */
    protected const NOT_ALLOWED_FILTER_FIELD_TYPE = CompanyCartSearchRestApiConstants::FILTER_FIELD_TYPE_COMPANY_UUID;

    /**
     * @param array<\Generated\Shared\Transfer\FilterFieldTransfer> $filterFieldTransfers
     *
     * @return bool
     */
    public function isApplicable(array $filterFieldTransfers): bool
    {
        $isApplicable = false;

        foreach ($filterFieldTransfers as $filterFieldTransfer) {
            if ($filterFieldTransfer->getType() === static::NOT_ALLOWED_FILTER_FIELD_TYPE) {
                return false;
            }

            if ($filterFieldTransfer->getType() === static::REQUIRED_FILTER_FIELD_TYPE) {
                $isApplicable = true;
            }
        }

        return $isApplicable;
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
        $idCustomer = null;

        foreach ($filterFieldTransfers as $filterFieldTransfer) {
            if ($filterFieldTransfer->getType() !== static::REQUIRED_FILTER_FIELD_TYPE) {
                continue;
            }

            $idCustomer = $filterFieldTransfer->getValue();
        }

        $queryJoinCollectionTransfer->addQueryJoin(
            (new QueryJoinTransfer())
                ->setJoinType(Criteria::INNER_JOIN)
                ->setLeft([SpyQuoteTableMap::COL_COMPANY_USER_REFERENCE])
                ->setRight([SpyCompanyUserTableMap::COL_COMPANY_USER_REFERENCE]),
        )->addQueryJoin(
            (new QueryJoinTransfer())
                ->setJoinType(Criteria::INNER_JOIN)
                ->setLeft([SpyCompanyUserTableMap::COL_FK_CUSTOMER])
                ->setRight([SpyCustomerTableMap::COL_ID_CUSTOMER])
                ->addQueryWhereCondition(
                    (new QueryWhereConditionTransfer())
                        ->setValue($idCustomer)
                        ->setColumn(SpyCustomerTableMap::COL_ID_CUSTOMER)
                        ->setComparison(Criteria::EQUAL),
                ),
        );

        $idPermission = $this->getRepository()->getIdPermissionByKey(SearchCartPermissionPlugin::KEY);

        if ($idPermission === null) {
            return $queryJoinCollectionTransfer;
        }

        return $queryJoinCollectionTransfer->addQueryJoin(
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
