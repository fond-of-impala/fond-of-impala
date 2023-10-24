<?php

namespace FondOfImpala\Zed\CompanyCartSearchRestApi\Communication\Plugin\CartSearchRestApiExtension;

use FondOfImpala\Shared\CompanyCartSearchRestApi\CompanyCartSearchRestApiConstants;
use FondOfOryx\Zed\CartSearchRestApiExtension\Dependency\Plugin\SearchQuoteQueryExpanderPluginInterface;
use Generated\Shared\Transfer\QueryJoinCollectionTransfer;
use Generated\Shared\Transfer\QueryJoinTransfer;
use Generated\Shared\Transfer\QueryWhereConditionTransfer;
use Orm\Zed\Customer\Persistence\Map\SpyCustomerTableMap;
use Orm\Zed\Quote\Persistence\Map\SpyQuoteTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CompanyCartSearchRestApi\Business\CompanyCartSearchRestApiFacadeInterface getFacade()
 */
class OnlyMineSearchQuoteQueryExpanderPlugin extends AbstractPlugin implements SearchQuoteQueryExpanderPluginInterface
{
    /**
     * @var array<string>
     */
    protected const REQUIRED_FILTER_FIELD_TYPES = [
        CompanyCartSearchRestApiConstants::FILTER_FIELD_TYPE_ID_CUSTOMER,
        CompanyCartSearchRestApiConstants::FILTER_FIELD_TYPE_ONLY_MINE,
    ];

    /**
     * @param array<\Generated\Shared\Transfer\FilterFieldTransfer> $filterFieldTransfers
     *
     * @return bool
     */
    public function isApplicable(array $filterFieldTransfers): bool
    {
        $requiredFilterFieldTypeCount = 0;

        foreach ($filterFieldTransfers as $filterFieldTransfer) {
            if (!in_array($filterFieldTransfer->getType(), static::REQUIRED_FILTER_FIELD_TYPES, true)) {
                continue;
            }

            $requiredFilterFieldTypeCount++;
        }

        return $requiredFilterFieldTypeCount === count(static::REQUIRED_FILTER_FIELD_TYPES);
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
        $onlyMine = null;
        $idCustomer = null;

        foreach ($filterFieldTransfers as $filterFieldTransfer) {
            if ($filterFieldTransfer->getType() === CompanyCartSearchRestApiConstants::FILTER_FIELD_TYPE_ONLY_MINE) {
                $onlyMine = (bool)$filterFieldTransfer->getValue();
            }

            if ($filterFieldTransfer->getType() === CompanyCartSearchRestApiConstants::FILTER_FIELD_TYPE_ID_CUSTOMER) {
                $idCustomer = $filterFieldTransfer->getValue();
            }
        }

        if ($onlyMine === null || $idCustomer === null) {
            return $queryJoinCollectionTransfer;
        }

        return $queryJoinCollectionTransfer->addQueryJoin(
            (new QueryJoinTransfer())
                ->setJoinType(Criteria::INNER_JOIN)
                ->setLeft([SpyQuoteTableMap::COL_CUSTOMER_REFERENCE])
                ->setRight([SpyCustomerTableMap::COL_CUSTOMER_REFERENCE])
                ->addQueryWhereCondition(
                    (new QueryWhereConditionTransfer())
                        ->setValue($idCustomer)
                        ->setColumn(SpyCustomerTableMap::COL_ID_CUSTOMER)
                        ->setComparison($onlyMine ? Criteria::EQUAL : Criteria::NOT_EQUAL),
                ),
        );
    }
}
