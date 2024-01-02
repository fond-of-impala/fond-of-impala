<?php

namespace FondOfImpala\Zed\CompanyType\Business\Model;

use FondOfImpala\Zed\CompanyType\Persistence\CompanyTypeEntityManagerInterface;
use Generated\Shared\Transfer\CompanyTypeTransfer;

class CompanyTypeWriter implements CompanyTypeWriterInterface
{
    protected CompanyTypeEntityManagerInterface $companyTypeEntityManager;

    /**
     * @param \FondOfImpala\Zed\CompanyType\Persistence\CompanyTypeEntityManagerInterface $companyTypeEntityManager
     */
    public function __construct(CompanyTypeEntityManagerInterface $companyTypeEntityManager)
    {
        $this->companyTypeEntityManager = $companyTypeEntityManager;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer
     */
    public function create(CompanyTypeTransfer $companyTypeTransfer): CompanyTypeTransfer
    {
        return $this->companyTypeEntityManager->persist($companyTypeTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer
     */
    public function update(CompanyTypeTransfer $companyTypeTransfer): CompanyTypeTransfer
    {
        $companyTypeTransfer->requireIdCompanyType();

        return $this->companyTypeEntityManager->persist($companyTypeTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return void
     */
    public function deleteById(CompanyTypeTransfer $companyTypeTransfer): void
    {
        $companyTypeTransfer->requireIdCompanyType();

        $this->companyTypeEntityManager->deleteById($companyTypeTransfer->getIdCompanyType());
    }
}
