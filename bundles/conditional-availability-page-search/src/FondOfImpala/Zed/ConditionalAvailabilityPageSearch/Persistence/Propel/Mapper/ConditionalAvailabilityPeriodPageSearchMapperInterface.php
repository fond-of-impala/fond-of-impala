<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer;
use Orm\Zed\ConditionalAvailabilityPageSearch\Persistence\FoiConditionalAvailabilityPeriodPageSearch;

interface ConditionalAvailabilityPeriodPageSearchMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
     * @param \Orm\Zed\ConditionalAvailabilityPageSearch\Persistence\FoiConditionalAvailabilityPeriodPageSearch $foiConditionalAvailabilityPeriodPageSearch
     *
     * @return \Orm\Zed\ConditionalAvailabilityPageSearch\Persistence\FoiConditionalAvailabilityPeriodPageSearch
     */
    public function mapTransferToEntity(
        ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer,
        FoiConditionalAvailabilityPeriodPageSearch $foiConditionalAvailabilityPeriodPageSearch
    ): FoiConditionalAvailabilityPeriodPageSearch;
}
