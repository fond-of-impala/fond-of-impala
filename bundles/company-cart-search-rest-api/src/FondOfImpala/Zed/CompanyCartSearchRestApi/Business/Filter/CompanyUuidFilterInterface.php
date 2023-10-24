<?php

namespace FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Filter;

use Generated\Shared\Transfer\FilterFieldTransfer;

interface CompanyUuidFilterInterface
{
    /**
     * @param \Generated\Shared\Transfer\FilterFieldTransfer $filterFieldTransfer
     *
     * @return string|null
     */
    public function filterByFilterField(FilterFieldTransfer $filterFieldTransfer): ?string;
}
