<?php

namespace FondOfImpala\Zed\CompanyUserReference\Business;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\CompanyUserReference\Persistence\CompanyUserReferenceRepositoryInterface getRepository()
 * @method \FondOfImpala\Zed\CompanyUserReference\Business\CompanyUserReferenceBusinessFactory getFactory()
 */
class CompanyUserReferenceFacade extends AbstractFacade implements CompanyUserReferenceFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function generateCompanyUserReference(): string
    {
        return $this->getFactory()->createCompanyUserReferenceGenerator()->generate();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function findCompanyUserByCompanyUserReference(
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserResponseTransfer {
        return $this->getFactory()->createCompanyUserReader()
            ->findCompanyUserByCompanyUserReference($companyUserTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $companyUserReference
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer|null
     */
    public function getCompanyByCompanyUserReference(string $companyUserReference): ?CompanyTransfer
    {
        return $this->getFactory()->createCompanyReader()->getByCompanyUserReference($companyUserReference);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $companyUserReference
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer|null
     */
    public function getCompanyBusinessUnitByCompanyUserReference(string $companyUserReference): ?CompanyBusinessUnitTransfer
    {
        return $this->getFactory()->createCompanyBusinessUnitReader()->getByCompanyUserReference($companyUserReference);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $companyUserReference
     * @param int $idCustomer
     *
     * @return int|null
     */
    public function getIdCompanyUserByCompanyUserReferenceAndIdCustomer(
        string $companyUserReference,
        int $idCustomer
    ): ?int {
        return $this->getRepository()->findIdCompanyUserByCompanyUserReferenceAndFkCustomer(
            $companyUserReference,
            $idCustomer,
        );
    }
}
