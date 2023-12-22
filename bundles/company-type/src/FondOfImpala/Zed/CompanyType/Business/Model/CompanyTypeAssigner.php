<?php

namespace FondOfImpala\Zed\CompanyType\Business\Model;

use FondOfImpala\Zed\CompanyType\CompanyTypeConfig;
use FondOfImpala\Zed\CompanyType\Persistence\CompanyTypeRepositoryInterface;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

class CompanyTypeAssigner implements CompanyTypeAssignerInterface
{
    protected CompanyTypeConfig $companyTypeConfig;

    protected CompanyTypeRepositoryInterface $companyTypeRepository;

    /**
     * @param \FondOfImpala\Zed\CompanyType\CompanyTypeConfig $companyTypeConfig
     * @param \FondOfImpala\Zed\CompanyType\Persistence\CompanyTypeRepositoryInterface $companyTypeRepository
     */
    public function __construct(
        CompanyTypeConfig $companyTypeConfig,
        CompanyTypeRepositoryInterface $companyTypeRepository
    ) {
        $this->companyTypeConfig = $companyTypeConfig;
        $this->companyTypeRepository = $companyTypeRepository;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyResponseTransfer $companyResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function assignDefaultCompanyTypeToNewCompany(
        CompanyResponseTransfer $companyResponseTransfer
    ): CompanyResponseTransfer {
        $companyTransfer = $companyResponseTransfer->getCompanyTransfer();

        if ($companyTransfer === null) {
            return $companyResponseTransfer;
        }

        $idCompanyType = $companyTransfer->getFkCompanyType();

        if ($idCompanyType !== null) {
            return $companyResponseTransfer;
        }

        $companyTypeTransfer = $this->getDefaultCompanyType();

        if ($companyTypeTransfer === null || $companyTypeTransfer->getIdCompanyType() === null) {
            return $companyResponseTransfer;
        }

        $companyTransfer->setFkCompanyType($companyTypeTransfer->getIdCompanyType());

        return $companyResponseTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    private function getDefaultCompanyType(): ?CompanyTypeTransfer
    {
        return $this->companyTypeRepository->getByName(
            $this->companyTypeConfig->getDefaultCompanyTypeName(),
        );
    }
}
