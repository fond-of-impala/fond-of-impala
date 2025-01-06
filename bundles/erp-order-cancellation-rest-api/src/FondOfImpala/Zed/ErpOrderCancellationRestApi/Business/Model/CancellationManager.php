<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model;

use ArrayObject;
use Exception;
use FondOfImpala\Shared\ErpOrderCancellationRestApi\ErpOrderCancellationRestApiConstants;
use FondOfImpala\Shared\ErpOrderCancellationRestApiExtension\ErpOrderCancellationRestApiExtensionConstants;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper\RestDataMapperInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper\RestFilterToFilterMapperInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Permission\PermissionCheckerInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderCancellationFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\ErpOrderCancellationRestApiRepositoryInterface;
use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationCollectionResponseTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationPaginationTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\Map\FoiErpOrderCancellationTableMap;
use Psr\Log\LoggerInterface;
use Throwable;

class CancellationManager implements CancellationManagerInterface
{
    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderCancellationFacadeInterface
     */
    protected ErpOrderCancellationRestApiToErpOrderCancellationFacadeInterface $erpOrderCancellationFacade;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderFacadeInterface
     */
    protected ErpOrderCancellationRestApiToErpOrderFacadeInterface $erpOrderFacade;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\ErpOrderCancellationRestApiRepositoryInterface
     */
    protected ErpOrderCancellationRestApiRepositoryInterface $repository;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper\RestDataMapperInterface
     */
    protected RestDataMapperInterface $restDataMapper;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Permission\PermissionCheckerInterface
     */
    protected PermissionCheckerInterface $permissionChecker;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper\RestFilterToFilterMapperInterface
     */
    protected RestFilterToFilterMapperInterface $restFilterToFilterMapper;

    /**
     * @param \FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderCancellationFacadeInterface $erpOrderCancellationFacade
     * @param \FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderFacadeInterface $erpOrderFacade
     * @param \FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\ErpOrderCancellationRestApiRepositoryInterface $repository
     * @param \FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper\RestDataMapperInterface $restDataMapper
     * @param \FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Permission\PermissionCheckerInterface $permissionChecker
     * @param \FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper\RestFilterToFilterMapperInterface $restFilterToFilterMapper
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        ErpOrderCancellationRestApiToErpOrderCancellationFacadeInterface $erpOrderCancellationFacade,
        ErpOrderCancellationRestApiToErpOrderFacadeInterface $erpOrderFacade,
        ErpOrderCancellationRestApiRepositoryInterface $repository,
        RestDataMapperInterface $restDataMapper,
        PermissionCheckerInterface $permissionChecker,
        RestFilterToFilterMapperInterface $restFilterToFilterMapper,
        LoggerInterface $logger
    ) {
        $this->erpOrderCancellationFacade = $erpOrderCancellationFacade;
        $this->erpOrderFacade = $erpOrderFacade;
        $this->repository = $repository;
        $this->restDataMapper = $restDataMapper;
        $this->permissionChecker = $permissionChecker;
        $this->restFilterToFilterMapper = $restFilterToFilterMapper;
        $this->logger = $logger;
    }

    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     *
     * @throws \Exception
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer|\Generated\Shared\Transfer\RestErrorMessageTransfer
     */
    public function addErpOrderCancellation(
        RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
    ): RestErpOrderCancellationResponseTransfer|RestErrorMessageTransfer {
        try {
            $attributes = $restErpOrderCancellationRequestTransfer->getAttributes();
            $erpOrderCancellationTransfer = $this->restDataMapper->mapFromRequest($restErpOrderCancellationRequestTransfer);

            $erpOrderCancellationTransfer->requireErpOrderReference()
                ->requireErpOrderExternalReference()
                ->requireDebitorNumber();

            $companyUser = $this->repository->getCompanyUserByIdCustomerAndDebtorNumber($attributes->getOriginator()->getIdCustomer(), $erpOrderCancellationTransfer->getDebitorNumber());

            if ($this->permissionChecker->checkPermission($erpOrderCancellationTransfer, $companyUser, ErpOrderCancellationRestApiExtensionConstants::PERMISSION_TYPE_CREATE) === false) {
                throw new Exception('Permission denied');
            }

            $erpOrder = $this->erpOrderFacade->findErpOrderByExternalReference($erpOrderCancellationTransfer->getErpOrderExternalReference());

            if ($erpOrder === null) {
                $erpOrder = $this->erpOrderFacade->findErpOrderByReference($erpOrderCancellationTransfer->getErpOrderReference());
            }

            if ($erpOrder === null) {
                throw new Exception(sprintf('ErpOrder with external reference "%s" or reference "%s" not found', $erpOrderCancellationTransfer->getErpOrderExternalReference(), $erpOrderCancellationTransfer->getErpOrderReference()));
            }

            if ($erpOrder->getFkCompanyBusinessUnit() !== $companyUser->getFkCompanyBusinessUnit()) {
                throw new Exception(sprintf('ErpOrder does not belong to this debtor %s!', $erpOrderCancellationTransfer->getDebitorNumber()));
            }

            $erpOrderCancellationTransfer->setErpOrderReference($erpOrder->getReference());
            $erpOrderCancellationTransfer->setErpOrderExternalReference($erpOrder->getExternalReference());

            $erpOrderCancellationTransfer->setFkCustomerRequested($companyUser->getCustomer()->getIdCustomer())
                ->setState(FoiErpOrderCancellationTableMap::COL_STATE_NEW);

            $response = $this->erpOrderCancellationFacade->createErpOrderCancellation($erpOrderCancellationTransfer)->getErpOrderCancellation();

            $restErpOrderCancellationTransfer = $this->restDataMapper->mapResponse($response);
            $restErpOrderCancellationTransfer->setErpOrder($erpOrder);

            return (new RestErpOrderCancellationResponseTransfer())
                ->setErpOrderCancellation($restErpOrderCancellationTransfer);
        } catch (Throwable $throwable) {
            $this->logger->error($throwable->getMessage(), $throwable->getTrace());

            return $this->createErrorTransfer(ErpOrderCancellationRestApiConstants::ERROR_MESSAGE_ADD, ErpOrderCancellationRestApiConstants::ERROR_CODE_ADD);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     *
     * @throws \Exception
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer|\Generated\Shared\Transfer\RestErrorMessageTransfer
     */
    public function updateErpOrderCancellation(
        RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
    ): RestErpOrderCancellationResponseTransfer|RestErrorMessageTransfer {
        try {
            $attributes = $restErpOrderCancellationRequestTransfer->getAttributes();
            $erpOrderCancellationUpdateTransfer = $this->restDataMapper->mapFromRequest($restErpOrderCancellationRequestTransfer);
            $companyUser = $this->repository->getCompanyUserByIdCustomerAndDebtorNumber($attributes->getOriginator()->getIdCustomer(), $erpOrderCancellationUpdateTransfer->getDebitorNumber());

            if ($this->permissionChecker->checkPermission($erpOrderCancellationUpdateTransfer, $companyUser, ErpOrderCancellationRestApiExtensionConstants::PERMISSION_TYPE_UPDATE) === false) {
                throw new Exception('Permission denied');
            }

            $erpOrderCancellationUpdateTransfer->requireUuid();
            $erpOrderCancellation = $this->repository->findErpOrderCancellationByUuid($erpOrderCancellationUpdateTransfer->getUuid());

            if ($erpOrderCancellation === null) {
                return $this->createErrorTransfer(ErpOrderCancellationRestApiConstants::ERROR_MESSAGE_NOT_FOUND, ErpOrderCancellationRestApiConstants::ERROR_CODE_NOT_FOUND);
            }

            $updatedItemsCollection = [];

            foreach ($erpOrderCancellationUpdateTransfer->getCancellationItems() as $item) {
                $updatedItemsCollection[$this->getItemIdentifier($item)] = $item;
            }

            foreach ($erpOrderCancellation->getCancellationItems() as $item) {
                if (!isset($updatedItemsCollection[$this->getItemIdentifier($item)])) {
                    $updatedItemsCollection[$this->getItemIdentifier($item)] = $item;
                }
            }

            if (
                ($erpOrderCancellationUpdateTransfer->getErpOrderReference() !== null && $erpOrderCancellation->getErpOrderReference() !== $erpOrderCancellationUpdateTransfer->getErpOrderReference())
                || ($erpOrderCancellationUpdateTransfer->getErpOrderExternalReference() !== null && $erpOrderCancellation->getErpOrderExternalReference() !== $erpOrderCancellationUpdateTransfer->getErpOrderExternalReference())
            ) {
                throw new Exception('ErpOrderReference and/or ErpOrderExternalReference cannot be changed');
            }

            $erpOrderCancellation->fromArray($erpOrderCancellationUpdateTransfer->modifiedToArray(), true)->setCancellationItems(new ArrayObject($updatedItemsCollection));

            $response = $this->erpOrderCancellationFacade->updateErpOrderCancellation($erpOrderCancellation);

            return (new RestErpOrderCancellationResponseTransfer())
                ->setErpOrderCancellation($this->restDataMapper->mapResponse($response->getErpOrderCancellation()));
        } catch (Throwable $throwable) {
            $this->logger->error($throwable->getMessage(), $throwable->getTrace());

            return $this->createErrorTransfer(ErpOrderCancellationRestApiConstants::ERROR_MESSAGE_UPDATE, ErpOrderCancellationRestApiConstants::ERROR_CODE_UPDATE);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     *
     * @throws \Exception
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer|\Generated\Shared\Transfer\RestErrorMessageTransfer
     */
    public function deleteErpOrderCancellation(
        RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
    ): RestErpOrderCancellationResponseTransfer|RestErrorMessageTransfer {
        try {
            $attributes = $restErpOrderCancellationRequestTransfer->getAttributes();
            $erpOrderCancellationTransfer = $this->restDataMapper->mapFromRequest($restErpOrderCancellationRequestTransfer);
            $companyUser = $this->repository->getCompanyUserByIdCustomerAndDebtorNumber($attributes->getOriginator()->getIdCustomer(), $erpOrderCancellationTransfer->getDebitorNumber());

            if ($this->permissionChecker->checkPermission($erpOrderCancellationTransfer, $companyUser, ErpOrderCancellationRestApiExtensionConstants::PERMISSION_TYPE_DELETE) === false) {
                throw new Exception('Permission denied');
            }

            $erpOrderCancellationTransfer->requireUuid();

            $erpOrderCancellation = $this->repository->findErpOrderCancellationByUuid($erpOrderCancellationTransfer->getUuid());

            if ($erpOrderCancellation === null) {
                throw new Exception(sprintf('ErpOrderCancellation with UUID "%s" not found', $erpOrderCancellationTransfer->getUuid()));
            }

            $this->erpOrderCancellationFacade->deleteErpOrderCancellationByIdErpOrderCancellation($erpOrderCancellation->getIdErpOrderCancellation());

            return (new RestErpOrderCancellationResponseTransfer());
        } catch (Throwable $throwable) {
            $this->logger->error($throwable->getMessage(), $throwable->getTrace());

            return $this->createErrorTransfer(ErpOrderCancellationRestApiConstants::ERROR_MESSAGE_DELETE, ErpOrderCancellationRestApiConstants::ERROR_CODE_DELETE);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationCollectionResponseTransfer|\Generated\Shared\Transfer\RestErrorMessageTransfer
     */
    public function getErpOrderCancellation(
        RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
    ): RestErpOrderCancellationCollectionResponseTransfer|RestErrorMessageTransfer {
        try {
            $filter = $this->restFilterToFilterMapper->fromRestRequest($restErpOrderCancellationRequestTransfer);

            $collection = $this->repository->findErpOrderCancellation($filter);
            $responseCollection = (new RestErpOrderCancellationCollectionResponseTransfer());

            foreach ($collection->getCancellations() as $cancellation) {
                $responseCollection->addErpOrderCancellation(
                    $this->restDataMapper->mapResponse($cancellation)
                );
            }

            $pagination = (new RestErpOrderCancellationPaginationTransfer())->fromArray($this->repository->getErpOrderCancellationPagination($filter)->toArray(), true);

            return $responseCollection->setPagination($pagination);
        } catch (Throwable $throwable) {
            $this->logger->error($throwable->getMessage(), $throwable->getTrace());

            return $this->createErrorTransfer(ErpOrderCancellationRestApiConstants::ERROR_MESSAGE_GET, ErpOrderCancellationRestApiConstants::ERROR_CODE_GET);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer $item
     *
     * @return string
     */
    protected function getItemIdentifier(ErpOrderCancellationItemTransfer $item): string
    {
        return sprintf('%s|%s', $item->getSku(), $item->getLineId());
    }

    /**
     * @param string $message
     * @param string $code
     * @param int $status
     *
     * @return \Generated\Shared\Transfer\RestErrorMessageTransfer
     */
    protected function createErrorTransfer(string $message, string $code, int $status = 400): RestErrorMessageTransfer
    {
        return (new RestErrorMessageTransfer())
            ->setDetail($message)
            ->setCode($code)
            ->setStatus($status);
    }
}
