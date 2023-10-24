<?php

namespace FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Filter;

use Generated\Shared\Transfer\FilterFieldTransfer;

interface IdCustomerFilterInterface
{
    /**
     * @param \Generated\Shared\Transfer\FilterFieldTransfer $filterFieldTransfer
     *
     * @return int|null
     */
    public function filterByFilterField(FilterFieldTransfer $filterFieldTransfer): ?int;
}
