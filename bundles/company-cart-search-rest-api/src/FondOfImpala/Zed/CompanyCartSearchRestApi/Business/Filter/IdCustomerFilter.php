<?php

namespace FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Filter;

use FondOfImpala\Shared\CompanyCartSearchRestApi\CompanyCartSearchRestApiConstants;
use Generated\Shared\Transfer\FilterFieldTransfer;

class IdCustomerFilter implements IdCustomerFilterInterface
{
    /**
     * @param \Generated\Shared\Transfer\FilterFieldTransfer $filterFieldTransfer
     *
     * @return int|null
     */
    public function filterByFilterField(FilterFieldTransfer $filterFieldTransfer): ?int
    {
        $filterFieldType = $filterFieldTransfer->getType();

        if ($filterFieldType !== CompanyCartSearchRestApiConstants::FILTER_FIELD_TYPE_ID_CUSTOMER) {
            return null;
        }

        return (int)$filterFieldTransfer->getValue();
    }
}
