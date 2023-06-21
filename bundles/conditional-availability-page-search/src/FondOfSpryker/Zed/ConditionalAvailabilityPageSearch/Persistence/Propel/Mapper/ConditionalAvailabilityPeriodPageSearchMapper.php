<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer;
use Orm\Zed\ConditionalAvailabilityPageSearch\Persistence\FosConditionalAvailabilityPeriodPageSearch;

class ConditionalAvailabilityPeriodPageSearchMapper implements ConditionalAvailabilityPeriodPageSearchMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
     * @param \Orm\Zed\ConditionalAvailabilityPageSearch\Persistence\FosConditionalAvailabilityPeriodPageSearch $fosConditionalAvailabilityPeriodPageSearch
     *
     * @return \Orm\Zed\ConditionalAvailabilityPageSearch\Persistence\FosConditionalAvailabilityPeriodPageSearch
     */
    public function mapTransferToEntity(
        ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer,
        FosConditionalAvailabilityPeriodPageSearch $fosConditionalAvailabilityPeriodPageSearch
    ): FosConditionalAvailabilityPeriodPageSearch {
        $fosConditionalAvailabilityPeriodPageSearch->fromArray(
            $conditionalAvailabilityPeriodPageSearchTransfer->modifiedToArray(false),
        );

        return $fosConditionalAvailabilityPeriodPageSearch;
    }
}
