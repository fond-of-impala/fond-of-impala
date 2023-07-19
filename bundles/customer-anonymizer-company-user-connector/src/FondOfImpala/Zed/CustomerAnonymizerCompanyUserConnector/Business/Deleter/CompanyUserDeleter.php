<?php

declare (strict_types=1);

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business\Deleter;

use FondOfImpala\Shared\CustomerAnonymizerCompanyUserConnector\CustomerAnonymizerCompanyUserConnectorConstants;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade\CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade\CustomerAnonymizerCompanyUserConnectorToEventFacadeInterface;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Persistence\CustomerAnonymizerCompanyUserConnectorRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyUserIdCollectionTransfer;
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
        $idCustomer = $customerTransfer->getIdCustomer();

        if ($idCustomer === null) {
            return;
        }

        $companyUserIdCollectionTransfer = $this->repository->findCompanyUserIdsByFkCustomer($idCustomer);

        if (count($companyUserIdCollectionTransfer->getCompanyUserIds()) <= 0) {
            return;
        }

        $this->eventFacade->trigger(
            CustomerAnonymizerCompanyUserConnectorConstants::EVENT_DELETE_COMPANY_USER,
            $companyUserIdCollectionTransfer,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserIdCollectionTransfer $companyUserIdCollectionTransfer
     *
     * @return void
     */
    public function deleteCompanyUserByCompanyUserIdCollection(
        CompanyUserIdCollectionTransfer $companyUserIdCollectionTransfer
    ): void {
        foreach (array_chunk($companyUserIdCollectionTransfer->getCompanyUserIds(), 100) as $companyUserIds) {
            $companyUserCriteriaFilterTransfer = (new CompanyUserCriteriaFilterTransfer())
                ->setCompanyUserIds($companyUserIds);

            $companyUserCollectionTransfer = $this->repository->findCompanyUsersByIds(
                $companyUserCriteriaFilterTransfer,
            );

            foreach ($companyUserCollectionTransfer->getCompanyUsers() as $companyUserTransfer) {
                $this->companyUserFacade->deleteCompanyUser($companyUserTransfer);
            }
        }
    }
}
