<?php

namespace FondOfImpala\Zed\CompanyTypeConverterExtension\Dependency\Plugin;

use Generated\Shared\Transfer\CompanyTransfer;

interface CompanyTypeConverterPreSavePluginInterface
{
    /**
     * Specification:
     *  - Plugin is triggered before company object is saved in case of a company type change.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function preSave(CompanyTransfer $companyTransfer): CompanyTransfer;
}
