<?php

declare (strict_types=1);

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business\Model;

use FondOfImpala\Shared\CustomerAnonymizerCompanyUserConnector\CustomerAnonymizerCompanyUserConnectorConstants;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade\CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade\CustomerAnonymizerCompanyUserConnectorToEventFacadeInterface;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Persistence\CustomerAnonymizerCompanyUserConnectorRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserIdCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;

class CompanyUserDeleter implements CompanyUserDeleterInterface
{
    /**
     * @var \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade\CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeInterface
     */
    protected CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeInterface $companyUserFacade;

    /**
     * @var \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade\CustomerAnonymizerCompanyUserConnectorToEventFacadeInterface
     */
    protected CustomerAnonymizerCompanyUserConnectorToEventFacadeInterface $eventFacade;

    /**
     * @var \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Persistence\CustomerAnonymizerCompanyUserConnectorRepositoryInterface
     */
    protected CustomerAnonymizerCompanyUserConnectorRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade\CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeInterface $companyUserFacade
     * @param \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade\CustomerAnonymizerCompanyUserConnectorToEventFacadeInterface $eventFacade
     * @param \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Persistence\CustomerAnonymizerCompanyUserConnectorRepositoryInterface $repository
     */
    public function __construct(
        CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeInterface $companyUserFacade,
        CustomerAnonymizerCompanyUserConnectorToEventFacadeInterface $eventFacade,
        CustomerAnonymizerCompanyUserConnectorRepositoryInterface $repository
    ) {
        $this->companyUserFacade = $companyUserFacade;
        $this->eventFacade = $eventFacade;
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function deleteByCustomer(CustomerTransfer $customerTransfer): void
    {
        $companyUserIds = $this->repository->findCompanyUserIdsByFkCustomer($customerTransfer->getIdCustomerOrFail());

        if (count($companyUserIds->getIds()) > 0) {
            $this->eventFacade->trigger(CustomerAnonymizerCompanyUserConnectorConstants::EVENT_DELETE_COMPANY_USER, $companyUserIds);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserIdCollectionTransfer $idCollectionTransfer
     *
     * @return void
     */
    public function deleteCompanyUserByIds(CompanyUserIdCollectionTransfer $idCollectionTransfer): void
    {
        foreach ($idCollectionTransfer->getIds() as $companyUserId) {
            $companyUserTransfer = (new CompanyUserTransfer())->setIdCompanyUser($companyUserId);
            $this->companyUserFacade->deleteCompanyUser($companyUserTransfer);
        }
    }
}
