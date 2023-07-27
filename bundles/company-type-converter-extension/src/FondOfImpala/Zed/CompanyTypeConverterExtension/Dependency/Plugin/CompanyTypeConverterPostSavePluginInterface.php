<?php

namespace FondOfImpala\Zed\CompanyTypeConverterExtension\Dependency\Plugin;

use Generated\Shared\Transfer\CompanyTransfer;

interface CompanyTypeConverterPostSavePluginInterface
{
    /**
     * Specification:
     * - Plugin is triggered after company object is saved in case of a company type change.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function postSave(CompanyTransfer $companyTransfer): CompanyTransfer;
}
