<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Creator;

use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer;

interface QuoteCreatorInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer
     */
    public function createByRestCompanyUserCartsRequest(
        RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
    ): RestCompanyUserCartsResponseTransfer;
}
