<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Updater;

use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer;

interface QuoteUpdaterInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer
     */
    public function updateByRestCompanyUserCartsRequest(
        RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
    ): RestCompanyUserCartsResponseTransfer;
}
