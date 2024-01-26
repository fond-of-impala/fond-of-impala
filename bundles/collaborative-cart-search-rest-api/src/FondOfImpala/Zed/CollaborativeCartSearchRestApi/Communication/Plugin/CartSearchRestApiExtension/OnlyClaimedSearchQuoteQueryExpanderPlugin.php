<?php

namespace FondOfImpala\Zed\CollaborativeCartSearchRestApi\Communication\Plugin\CartSearchRestApiExtension;

use FondOfImpala\Shared\CollaborativeCartSearchRestApi\CollaborativeCartSearchRestApiConstants;
use FondOfOryx\Zed\CartSearchRestApiExtension\Dependency\Plugin\SearchQuoteQueryExpanderPluginInterface;
use Generated\Shared\Transfer\QueryJoinCollectionTransfer;
use Generated\Shared\Transfer\QueryJoinTransfer;
use Generated\Shared\Transfer\QueryWhereConditionTransfer;
use Orm\Zed\Quote\Persistence\Map\SpyQuoteTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CompanyCartSearchRestApi\Business\CompanyCartSearchRestApiFacadeInterface getFacade()
 */
class OnlyClaimedSearchQuoteQueryExpanderPlugin extends AbstractPlugin implements SearchQuoteQueryExpanderPluginInterface
{
    /**
     * @var array<string>
     */
    protected const REQUIRED_FILTER_FIELD_TYPES = [
        CollaborativeCartSearchRestApiConstants::FILTER_FIELD_TYPE_ONLY_CLAIMED,
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

            ++$requiredFilterFieldTypeCount;
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
        $onlyClaimed = null;
        $callbackFilter = static function (string $value): ?bool {
            if (strtolower($value) === 'true') {
                return true;
            }

            if (strtolower($value) === 'false') {
                return false;
            }

            return null;
        };

        foreach ($filterFieldTransfers as $filterFieldTransfer) {
            if ($filterFieldTransfer->getType() === CollaborativeCartSearchRestApiConstants::FILTER_FIELD_TYPE_ONLY_CLAIMED) {
                $onlyClaimed = filter_var($filterFieldTransfer->getValue(), FILTER_CALLBACK, [
                    'options' => $callbackFilter,
                ]);
            }
        }

        if ($onlyClaimed === null) {
            return $queryJoinCollectionTransfer;
        }

        return $queryJoinCollectionTransfer->addQueryJoin(
            (new QueryJoinTransfer())->addQueryWhereCondition(
                (new QueryWhereConditionTransfer())
                    ->setColumn(SpyQuoteTableMap::COL_ORIGINAL_CUSTOMER_REFERENCE)
                    ->setComparison($onlyClaimed ? Criteria::ISNOTNULL : Criteria::ISNULL),
            ),
        );
    }
}
