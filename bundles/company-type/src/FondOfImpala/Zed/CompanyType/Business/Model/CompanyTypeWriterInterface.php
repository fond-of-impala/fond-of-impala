<?php

namespace FondOfImpala\Zed\CompanyType\Business\Model;

use Generated\Shared\Transfer\CompanyTypeTransfer;

interface CompanyTypeWriterInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer
     */
    public function create(CompanyTypeTransfer $companyTypeTransfer): CompanyTypeTransfer;

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer
     */
    public function update(CompanyTypeTransfer $companyTypeTransfer): CompanyTypeTransfer;

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return void
     */
    public function deleteById(CompanyTypeTransfer $companyTypeTransfer): void;
}
