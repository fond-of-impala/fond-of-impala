<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Business\Model;

use Generated\Shared\Transfer\CompanyTransfer;

interface CompanyTypeConverterPluginExecutorInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function executeCompanyTypeConverterPreSavePlugins(
        CompanyTransfer $companyTransfer
    ): CompanyTransfer;

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function executeCompanyTypeConverterPostSavePlugins(
        CompanyTransfer $companyTransfer
    ): CompanyTransfer;
}
