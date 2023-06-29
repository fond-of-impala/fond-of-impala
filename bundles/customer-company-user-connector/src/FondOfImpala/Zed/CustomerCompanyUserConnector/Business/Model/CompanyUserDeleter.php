<?php

declare (strict_types=1);

namespace FondOfImpala\Zed\CustomerCompanyUserConnector\Business\Model;

use FondOfImpala\Zed\CustomerCompanyUserConnector\Dependency\Facade\CustomerCompanyUserConnectorToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CustomerCompanyUserConnector\Persistence\CustomerCompanyUserConnectorRepositoryInterface;
use Generated\Shared\Transfer\CustomerTransfer;

class CompanyUserDeleter implements CompanyUserDeleterInterface
{
    /**
     * @var \FondOfImpala\Zed\CustomerCompanyUserConnector\Dependency\Facade\CustomerCompanyUserConnectorToCompanyUserFacadeInterface
     */
    protected CustomerCompanyUserConnectorToCompanyUserFacadeInterface $companyUserFacade;

    /**
     * @var \FondOfImpala\Zed\CustomerCompanyUserConnector\Persistence\CustomerCompanyUserConnectorRepositoryInterface
     */
    protected CustomerCompanyUserConnectorRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\CustomerCompanyUserConnector\Dependency\Facade\CustomerCompanyUserConnectorToCompanyUserFacadeInterface $companyUserFacade
     * @param \FondOfImpala\Zed\CustomerCompanyUserConnector\Persistence\CustomerCompanyUserConnectorRepositoryInterface $repository
     */
    public function __construct(
        CustomerCompanyUserConnectorToCompanyUserFacadeInterface $companyUserFacade,
        CustomerCompanyUserConnectorRepositoryInterface $repository
    ) {
        $this->companyUserFacade = $companyUserFacade;
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function deleteCompanyUserForCustomer(CustomerTransfer $customerTransfer): void
    {
        $companyUserCollection = $this->repository->findCompanyUsersByFkCustomer($customerTransfer->getIdCustomerOrFail());

        foreach ($companyUserCollection->getCompanyUsers() as $companyUser) {
            $this->companyUserFacade->deleteCompanyUser($companyUser);
        }
    }
}
