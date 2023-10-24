<?php

namespace FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Expander;

use FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Reader\CompanyReaderInterface;
use Generated\Shared\Transfer\QueryJoinCollectionTransfer;
use Generated\Shared\Transfer\QueryJoinTransfer;
use Generated\Shared\Transfer\QueryWhereConditionTransfer;
use Orm\Zed\Company\Persistence\Map\SpyCompanyTableMap;
use Orm\Zed\CompanyUser\Persistence\Map\SpyCompanyUserTableMap;
use Orm\Zed\Customer\Persistence\Map\SpyCustomerTableMap;
use Orm\Zed\Quote\Persistence\Map\SpyQuoteTableMap;
use Propel\Runtime\ActiveQuery\Criteria;

class QueryJoinCollectionExpander implements QueryJoinCollectionExpanderInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Reader\CompanyReaderInterface
     */
    protected CompanyReaderInterface $companyReader;

    /**
     * @param \FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Reader\CompanyReaderInterface $companyReader
     */
    public function __construct(CompanyReaderInterface $companyReader)
    {
        $this->companyReader = $companyReader;
    }

    /**
     * @param array $filterFieldTransfers
     * @param \Generated\Shared\Transfer\QueryJoinCollectionTransfer $queryJoinCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\QueryJoinCollectionTransfer
     */
    public function expand(
        array $filterFieldTransfers,
        QueryJoinCollectionTransfer $queryJoinCollectionTransfer
    ): QueryJoinCollectionTransfer {
        $idCompany = $this->companyReader->getIdByFilterFields($filterFieldTransfers);

        if ($idCompany === null) {
            $idCompany = -1;
        }

        return $queryJoinCollectionTransfer->addQueryJoin(
            (new QueryJoinTransfer())
                ->setJoinType(Criteria::INNER_JOIN)
                ->setLeft([SpyQuoteTableMap::COL_COMPANY_USER_REFERENCE])
                ->setRight([SpyCompanyUserTableMap::COL_COMPANY_USER_REFERENCE])
                ->addQueryWhereCondition(
                    (new QueryWhereConditionTransfer())
                        ->setValue((string)$idCompany)
                        ->setColumn(SpyCompanyUserTableMap::COL_FK_COMPANY)
                        ->setComparison(Criteria::EQUAL),
                ),
        )->addQueryJoin(
            (new QueryJoinTransfer())
                ->setJoinType(Criteria::INNER_JOIN)
                ->setLeft([SpyCompanyUserTableMap::COL_FK_CUSTOMER])
                ->setRight([SpyCustomerTableMap::COL_ID_CUSTOMER])
                ->addQueryWhereCondition(
                    (new QueryWhereConditionTransfer())
                        ->setColumn(SpyCustomerTableMap::COL_ANONYMIZED_AT)
                        ->setComparison(Criteria::ISNULL),
                ),
        );
    }
}
