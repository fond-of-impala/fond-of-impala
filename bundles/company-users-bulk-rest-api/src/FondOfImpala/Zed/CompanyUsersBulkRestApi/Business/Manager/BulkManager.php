<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Manager;

use ArrayObject;
use Exception;
use FondOfImpala\Shared\CompanyUsersBulkRestApi\CompanyUsersBulkRestApiConstants;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Permission\PermissionCheckerInterface;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\PluginExecutioner\BulkDataPluginExecutionerInterface;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade\CompanyUsersBulkRestApiToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade\CompanyUsersBulkRestApiToEventFacadeInterface;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepositoryInterface;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUsersBulkCompanyTransfer;
use Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer;
use Generated\Shared\Transfer\CompanyUsersBulkPreparationTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkItemCollectionTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer;
use Psr\Log\LoggerInterface;
use Throwable;

class BulkManager implements BulkManagerInterface
{
    protected PermissionCheckerInterface $permissionChecker;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade\CompanyUsersBulkRestApiToEventFacadeInterface
     */
    protected CompanyUsersBulkRestApiToEventFacadeInterface $eventFacade;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade\CompanyUsersBulkRestApiToCompanyUserFacadeInterface
     */
    protected CompanyUsersBulkRestApiToCompanyUserFacadeInterface $companyUserFacade;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\PluginExecutioner\BulkDataPluginExecutionerInterface
     */
    protected BulkDataPluginExecutionerInterface $pluginExecutioner;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepositoryInterface
     */
    protected CompanyUsersBulkRestApiRepositoryInterface $repository;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @param \FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Permission\PermissionCheckerInterface $permissionChecker
     * @param \FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade\CompanyUsersBulkRestApiToEventFacadeInterface $eventFacade
     * @param \FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade\CompanyUsersBulkRestApiToCompanyUserFacadeInterface $companyUserFacade
     * @param \FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\PluginExecutioner\BulkDataPluginExecutionerInterface $pluginExecutioner
     * @param \FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepositoryInterface $repository
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        PermissionCheckerInterface                          $permissionChecker,
        CompanyUsersBulkRestApiToEventFacadeInterface       $eventFacade,
        CompanyUsersBulkRestApiToCompanyUserFacadeInterface $companyUserFacade,
        BulkDataPluginExecutionerInterface                  $pluginExecutioner,
        CompanyUsersBulkRestApiRepositoryInterface          $repository,
        LoggerInterface                                     $logger
    )
    {
        $this->permissionChecker = $permissionChecker;
        $this->eventFacade = $eventFacade;
        $this->companyUserFacade = $companyUserFacade;
        $this->pluginExecutioner = $pluginExecutioner;
        $this->repository = $repository;
        $this->logger = $logger;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer $restCompanyUsersBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer
     */
    public function handleBulkRequest(
        RestCompanyUsersBulkRequestTransfer $restCompanyUsersBulkRequestTransfer
    ): RestCompanyUsersBulkResponseTransfer
    {
        try {
            $restCompanyUsersBulkRequestTransfer = $this->pluginExecutioner->executePreHandlePlugins($restCompanyUsersBulkRequestTransfer);

            if (!$this->permissionChecker->check($restCompanyUsersBulkRequestTransfer)) {
                return $this->pluginExecutioner->executePostHandlePlugins($this->createEmptyResponseTransfer()
                    ->setCode(CompanyUsersBulkRestApiConstants::ERROR_CODE_PERMISSION_DENIED)
                    ->setError(CompanyUsersBulkRestApiConstants::ERROR_MESSAGE_MISSING_PERMISSION)
                    ->setRequest($restCompanyUsersBulkRequestTransfer));
            }

            $attributes = $restCompanyUsersBulkRequestTransfer->getAttributes();

            if ($attributes !== null && $attributes->getAssign()->count() > 0) {
                $this->eventFacade->trigger(CompanyUsersBulkRestApiConstants::BULK_ASSIGN, $this->createCollectionTransfer($attributes->getAssign()));
            }

            if ($attributes !== null && $attributes->getUnassign()->count() > 0) {
                $this->eventFacade->trigger(CompanyUsersBulkRestApiConstants::BULK_UNASSIGN, $this->createCollectionTransfer($attributes->getUnassign()));
            }
        } catch (Throwable $throwable) {
            return $this->pluginExecutioner->executePostHandlePlugins(
                $this->createEmptyResponseTransfer()
                    ->setCode(CompanyUsersBulkRestApiConstants::ERROR_CODE)
                    ->setIsSuccessful(false)
                    ->setError($throwable->getMessage()),
            );
        }

        return $this->pluginExecutioner->executePostHandlePlugins(
            $this->createEmptyResponseTransfer()
                ->setCode(CompanyUsersBulkRestApiConstants::SUCCESS_CODE)
                ->setIsSuccessful(true),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersBulkItemCollectionTransfer $restCompanyUsersBulkItemCollectionTransfer
     *
     * @return void
     */
    public function createCompanyUser(RestCompanyUsersBulkItemCollectionTransfer $restCompanyUsersBulkItemCollectionTransfer): void
    {
        try {
            $prepareDataCollection = $this->prepareData($restCompanyUsersBulkItemCollectionTransfer);

            foreach ($prepareDataCollection->getItems() as $prepareData) {
                $company = $prepareData->getCompanyOrFail();
                $customer = $prepareData->getCustomerOrFail();
                $role = $this->resolveRole($company, $prepareData->getItem()->getRole());
                $roleCollection = (new CompanyRoleCollectionTransfer())->addRole($role);
                foreach ($company->getCompanyBusinessUnits() as $companyBusinessUnit) {
                    $companyUserTransfer = $this->createDummyCompanyUserTransfer()
                        ->setCustomerReference($customer->getCustomerReference())
                        ->setFkCustomer($customer->getIdCustomer())
                        ->setCompanyRoleCollection($roleCollection)
                        ->setFkCompany($company->getIdCompany())
                        ->setCompany((new CompanyTransfer())->fromArray($company->toArray(), true))
                        ->setCustomer((new CustomerTransfer())->fromArray($customer->toArray(), true))
                        ->setFkCompanyBusinessUnit($companyBusinessUnit->getIdCompanyBusinessUnit());

                    if ($this->repository->isCompanyUserAlreadyAvailable($companyUserTransfer) === true) {
                        continue;
                    }

                    $response = $this->companyUserFacade->create($companyUserTransfer);

                    if (!$response->getIsSuccessful()) {
                        $this->logger->error(sprintf('Could not create companyUser for customer "%s" and company "%s"', $customer->getCustomerReference(), $company->getUuid()));
                        $this->logger->error(json_encode($companyUserTransfer->toArray()));
                    }
                }
            }
        } catch (Throwable $throwable) {
            $this->logger->error($throwable->getMessage(), $throwable->getTrace());
        }
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersBulkItemCollectionTransfer $restCompanyUsersBulkItemCollectionTransfer
     *
     * @return void
     */
    public function deleteCompanyUser(RestCompanyUsersBulkItemCollectionTransfer $restCompanyUsersBulkItemCollectionTransfer): void
    {
        try {
            $prepareDataCollection = $this->prepareData($restCompanyUsersBulkItemCollectionTransfer);

            foreach ($prepareDataCollection->getItems() as $prepareData) {
                $company = $prepareData->getCompanyOrFail();
                $customer = $prepareData->getCustomerOrFail();

                $companyUserCollectionTransfer = $this->repository->findCompanyUsersByFkCompanyAndFkCustomer($company->getIdCompany(), $customer->getIdCustomer());
                foreach ($companyUserCollectionTransfer->getCompanyUsers() as $companyUserTransfer) {
                    if ($companyUserTransfer->getCompanyRole()->getName() !== $prepareData->getItem()->getRole()) {
                        continue;
                    }

                    $response = $this->companyUserFacade->deleteCompanyUser($companyUserTransfer);

                    if (!$response->getIsSuccessful()) {
                        $this->logger->error(sprintf('Could not delete companyUser for customer "%s" and company "%s"', $customer->getCustomerReference(), $company->getUuid()));
                        $this->logger->error(json_encode($companyUserTransfer->toArray()));
                    }
                }
            }
        } catch (Throwable $throwable) {
            $this->logger->error($throwable->getMessage(), $throwable->getTrace());
        }
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersBulkItemCollectionTransfer $restCompanyUsersBulkItemCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer
     */
    protected function prepareData(
        RestCompanyUsersBulkItemCollectionTransfer $restCompanyUsersBulkItemCollectionTransfer
    ): CompanyUsersBulkPreparationCollectionTransfer
    {
        $collection = new CompanyUsersBulkPreparationCollectionTransfer();

        foreach ($restCompanyUsersBulkItemCollectionTransfer->getItems() as $item) {
            $company = $item->getCompany();
            $customer = $item->getCustomer();

            if ($company === null || $customer === null) {
                continue;
            }

            $preparedItem = (new CompanyUsersBulkPreparationTransfer())->setItem($item);
            $collection->addItem($preparedItem);
        }

        return $this->incompleteDataCleanup($this->pluginExecutioner->executeExpand($collection));
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer $collection
     * @return \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer
     */
    protected function incompleteDataCleanup(CompanyUsersBulkPreparationCollectionTransfer $collection): CompanyUsersBulkPreparationCollectionTransfer
    {
        $cleanupCollection = new CompanyUsersBulkPreparationCollectionTransfer();

        foreach ($collection->getItems() as $itemTransfer) {
            if ($itemTransfer->getCompany() === null || $itemTransfer->getCustomer() === null) {
                $this->logger->warning(sprintf('Customer or Company not found! Data: %s', json_encode($itemTransfer->getItem()->toArray())));
                continue;
            }
            $cleanupCollection->addItem($itemTransfer);
        }

        return $cleanupCollection;
    }

    /**
     * @return \Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer
     */
    protected function createEmptyResponseTransfer(): RestCompanyUsersBulkResponseTransfer
    {
        return new RestCompanyUsersBulkResponseTransfer();
    }

    /**
     * @param \ArrayObject $arrayObject
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersBulkItemCollectionTransfer
     */
    protected function createCollectionTransfer(ArrayObject $arrayObject): RestCompanyUsersBulkItemCollectionTransfer
    {
        return (new RestCompanyUsersBulkItemCollectionTransfer())->setItems($arrayObject);
    }

    /**
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected function createDummyCompanyUserTransfer(): CompanyUserTransfer
    {
        return (new CompanyUserTransfer())
            ->setIsActive(true)
            ->setIsDefault(false);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUsersBulkCompanyTransfer $companyTransfer
     * @param string $role
     *
     * @return \Generated\Shared\Transfer\CompanyRoleTransfer
     * @throws \Exception
     *
     */
    protected function resolveRole(CompanyUsersBulkCompanyTransfer $companyTransfer, string $role): CompanyRoleTransfer
    {
        foreach ($companyTransfer->getCompanyRoles() as $companyRole) {
            if ($role === $companyRole->getName()) {
                return (new CompanyRoleTransfer())->fromArray($companyRole->toArray(), true);
            }
        }

        throw new Exception(sprintf('Role with given name "%s" not found!', $role));
    }
}
