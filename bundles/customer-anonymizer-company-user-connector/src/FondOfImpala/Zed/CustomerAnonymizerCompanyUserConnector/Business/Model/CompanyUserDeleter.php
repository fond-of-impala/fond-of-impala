<?php

declare (strict_types=1);

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business\Model;

use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade\CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Persistence\CustomerAnonymizerCompanyUserConnectorRepositoryInterface;
use Generated\Shared\Transfer\CustomerTransfer;

class CompanyUserDeleter implements CompanyUserDeleterInterface
{
    /**
     * @var \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade\CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeInterface
     */
    protected CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeInterface $companyUserFacade;

    /**
     * @var \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Persistence\CustomerAnonymizerCompanyUserConnectorRepositoryInterface
     */
    protected CustomerAnonymizerCompanyUserConnectorRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade\CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeInterface $companyUserFacade
     * @param \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Persistence\CustomerAnonymizerCompanyUserConnectorRepositoryInterface $repository
     */
    public function __construct(
        CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeInterface $companyUserFacade,
        CustomerAnonymizerCompanyUserConnectorRepositoryInterface $repository
    ) {
        $this->companyUserFacade = $companyUserFacade;
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function deleteByCustomer(CustomerTransfer $customerTransfer): void
    {
        $companyUserCollection = $this->repository->findCompanyUsersByFkCustomer($customerTransfer->getIdCustomerOrFail());

        foreach ($companyUserCollection->getCompanyUsers() as $companyUser) {
            $this->companyUserFacade->deleteCompanyUser($companyUser);
        }
    }
}
