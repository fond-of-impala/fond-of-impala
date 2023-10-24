<?php

namespace FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Filter;

use FondOfImpala\Shared\CompanyCartSearchRestApi\CompanyCartSearchRestApiConstants;
use Generated\Shared\Transfer\FilterFieldTransfer;

class CompanyUuidFilter implements CompanyUuidFilterInterface
{
    /**
     * @param \Generated\Shared\Transfer\FilterFieldTransfer $filterFieldTransfer
     *
     * @return string|null
     */
    public function filterByFilterField(FilterFieldTransfer $filterFieldTransfer): ?string
    {
        $filterFieldType = $filterFieldTransfer->getType();

        if ($filterFieldType !== CompanyCartSearchRestApiConstants::FILTER_FIELD_TYPE_COMPANY_UUID) {
            return null;
        }

        return $filterFieldTransfer->getValue();
    }
}
