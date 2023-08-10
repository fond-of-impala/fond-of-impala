<?php

namespace FondOfImpala\Zed\CompanyPriceList\Communication\Plugin\PriceListExtension;

use ArrayObject;
use FondOfImpala\Shared\CompanyPriceList\CompanyPriceListConstants;
use FondOfOryx\Zed\PriceListExtension\Dependency\Plugin\SearchPriceListQueryExpanderPluginInterface;
use Generated\Shared\Transfer\QueryJoinCollectionTransfer;
use Generated\Shared\Transfer\QueryJoinTransfer;
use Generated\Shared\Transfer\QueryWhereConditionTransfer;
use Orm\Zed\Company\Persistence\Map\SpyCompanyTableMap;
use Orm\Zed\CompanyUser\Persistence\Map\SpyCompanyUserTableMap;
use Orm\Zed\PriceList\Persistence\Map\FoiPriceListTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CompanyPriceList\Business\CompanyPriceListFacadeInterface getFacade()
 */
class CompanyCustomerSearchPriceListQueryExpanderPlugin extends AbstractPlugin implements SearchPriceListQueryExpanderPluginInterface
{
    /**
     * Specification:
     * - Returns true if plugin is applicable for given filters.
     *
     * @api
     *
     * @param array<\Generated\Shared\Transfer\FilterFieldTransfer> $filterFieldTransfers
     *
     * @return bool
     */
    public function isApplicable(array $filterFieldTransfers): bool
    {
        foreach ($filterFieldTransfers as $fieldTransfer) {
            if ($fieldTransfer->getType() === CompanyPriceListConstants::FILTER_FIELD_TYPE_ID_CUSTOMER) {
                return true;
            }
        }

        return false;
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
        $filterFieldTransfer = null;

        foreach ($filterFieldTransfers as $currentFilterFieldTransfer) {
            if ($currentFilterFieldTransfer->getType() === CompanyPriceListConstants::FILTER_FIELD_TYPE_ID_CUSTOMER) {
                $filterFieldTransfer = $currentFilterFieldTransfer;

                break;
            }
        }

        if ($filterFieldTransfer === null || $filterFieldTransfer->getValue() === null) {
            return $queryJoinCollectionTransfer;
        }

        $whereConditions = [
            (new QueryWhereConditionTransfer())
                ->setValue($filterFieldTransfer->getValue())
                ->setColumn(SpyCompanyUserTableMap::COL_FK_CUSTOMER)
                ->setComparison(Criteria::EQUAL),
        ];

        $queryJoinCollectionTransfer->addQueryJoin(
            (new QueryJoinTransfer())
                ->setJoinType(Criteria::INNER_JOIN)
                ->setLeft([FoiPriceListTableMap::COL_ID_PRICE_LIST])
                ->setRight([SpyCompanyTableMap::COL_FK_PRICE_LIST]),
        );

        $queryJoinCollectionTransfer->addQueryJoin(
            (new QueryJoinTransfer())
                ->setJoinType(Criteria::INNER_JOIN)
                ->setLeft([SpyCompanyTableMap::COL_ID_COMPANY])
                ->setRight([SpyCompanyUserTableMap::COL_FK_COMPANY])
                ->setWhereConditions(new ArrayObject($whereConditions)),
        );

        return $queryJoinCollectionTransfer;
    }
}
