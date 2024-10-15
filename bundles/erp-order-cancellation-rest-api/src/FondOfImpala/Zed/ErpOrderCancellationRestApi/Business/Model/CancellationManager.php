<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model;

use ArrayObject;
use Exception;
use FondOfImpala\Shared\ErpOrderCancellationRestApi\ErpOrderCancellationRestApiConstants;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper\RestDataMapperInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper\RestFilterToFilterMapperInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderCancellationFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\ErpOrderCancellationRestApiRepositoryInterface;
use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationAttributesTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationCollectionResponseTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationPaginationTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Psr\Log\LoggerInterface;
use Throwable;

class CancellationManager implements CancellationManagerInterface
{
    /**
     * @var string
     */
    protected const PERMISSION_KEY_MANAGE = 'CanManageCancellationRequest';

    /**
     * @var string
     */
    protected const PERMISSION_KEY_REQUEST = 'CanCreateCancellationRequest';

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderCancellationFacadeInterface
     */
    protected ErpOrderCancellationRestApiToErpOrderCancellationFacadeInterface $erpOrderCancellationFacade;

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
     * @var \FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper\RestFilterToFilterMapperInterface
     */
    protected RestFilterToFilterMapperInterface $restFilterToFilterMapper;

    /**
     * @param \FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderCancellationFacadeInterface $erpOrderCancellationFacade
     * @param \FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\ErpOrderCancellationRestApiRepositoryInterface $repository
     * @param \FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper\RestDataMapperInterface $restDataMapper
     * @param \FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper\RestFilterToFilterMapperInterface $restFilterToFilterMapper
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        ErpOrderCancellationRestApiToErpOrderCancellationFacadeInterface $erpOrderCancellationFacade,
        ErpOrderCancellationRestApiRepositoryInterface $repository,
        RestDataMapperInterface $restDataMapper,
        RestFilterToFilterMapperInterface $restFilterToFilterMapper,
        LoggerInterface $logger
    ) {
        $this->erpOrderCancellationFacade = $erpOrderCancellationFacade;
        $this->repository = $repository;
        $this->restDataMapper = $restDataMapper;
        $this->restFilterToFilterMapper = $restFilterToFilterMapper;
        $this->logger = $logger;
    }

    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer|\Generated\Shared\Transfer\RestErrorMessageTransfer
     */
    public function addErpOrderCancellation(
        RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
    ): RestErpOrderCancellationResponseTransfer|RestErrorMessageTransfer {
        try {
            $response = $this->createErpOrderCancellation($restErpOrderCancellationRequestTransfer->getAttributes());

            return (new RestErpOrderCancellationResponseTransfer())
                ->setErpOrderCancellation($this->restDataMapper->mapResponse($response));
        } catch (Throwable $throwable) {
            $this->logger->error($throwable->getMessage(), $throwable->getTrace());

            return $this->createErrorTransfer(ErpOrderCancellationRestApiConstants::ERROR_MESSAGE_ADD, ErpOrderCancellationRestApiConstants::ERROR_CODE_ADD);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer|\Generated\Shared\Transfer\RestErrorMessageTransfer
     */
    public function updateErpOrderCancellation(
        RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
    ): RestErpOrderCancellationResponseTransfer|RestErrorMessageTransfer {
        try {
            $restErpOrderCancellationAttributesTransfer = $restErpOrderCancellationRequestTransfer->getAttributes();
            $restErpOrderCancellationAttributesTransfer->requireUuid();
            $erpOrderCancellation = $this->repository->findErpOrderCancellationByUuid($restErpOrderCancellationAttributesTransfer->getUuid());

            if ($erpOrderCancellation === null) {
                return $this->createErrorTransfer(ErpOrderCancellationRestApiConstants::ERROR_MESSAGE_NOT_FOUND, ErpOrderCancellationRestApiConstants::ERROR_CODE_NOT_FOUND);
            }

            $erpOrderCancellationUpdateTransfer = $this->restDataMapper->mapFromRequest($restErpOrderCancellationRequestTransfer);

            $updatedItemsCollection = [];

            foreach ($erpOrderCancellationUpdateTransfer->getCancellationItems() as $item) {
                $updatedItemsCollection[$this->getItemIdentifier($item)] = $item;
            }

            foreach ($erpOrderCancellation->getCancellationItems() as $item) {
                if (!isset($updatedItemsCollection[$this->getItemIdentifier($item)])) {
                    $updatedItemsCollection[$this->getItemIdentifier($item)] = $item;
                }
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
     * @param \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer $item
     *
     * @return string
     */
    protected function getItemIdentifier(ErpOrderCancellationItemTransfer $item): string
    {
        return sprintf('%s|%s', $item->getSku(), $item->getLineId());
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
            $attributes->requireUuid();

            $erpOrderCancellation = $this->repository->findErpOrderCancellationByUuid($attributes->getUuid());

            if ($erpOrderCancellation === null) {
                throw new Exception(sprintf('ErpOrderCancellation with UUID "%s" not found', $attributes->getUuid()));
            }

            //ToDo Check permission

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
                $responseCollection->addErpOrderCancellation((new RestErpOrderCancellationTransfer())->fromArray($cancellation->toArray(), true));
            }

            $pagination = (new RestErpOrderCancellationPaginationTransfer())->fromArray($this->repository->getErpOrderCancellationPagination($filter)->toArray(), true);

            return $responseCollection->setPagination($pagination);
        } catch (Throwable $throwable) {
            $this->logger->error($throwable->getMessage(), $throwable->getTrace());

            return $this->createErrorTransfer(ErpOrderCancellationRestApiConstants::ERROR_MESSAGE_GET, ErpOrderCancellationRestApiConstants::ERROR_CODE_GET);
        }
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

    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationAttributesTransfer $restErpOrderCancellationAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    protected function createErpOrderCancellation(
        RestErpOrderCancellationAttributesTransfer $restErpOrderCancellationAttributesTransfer
    ): ErpOrderCancellationTransfer {
        $restErpOrderCancellationAttributesTransfer
            ->requireErpOrderReference()
            ->requireErpOrderExternalReference()
            ->requireDebitorNumber();

        $originatorId = $this->repository->getIdCustomerByReference($restErpOrderCancellationAttributesTransfer->getOriginatorReference());

        $erpOrderCancellationTransfer = (new ErpOrderCancellationTransfer())
            ->setFkCustomerRequested($originatorId)
            ->setDebitorNumber($restErpOrderCancellationAttributesTransfer->getDebitorNumber())
            ->setErpOrderReference($restErpOrderCancellationAttributesTransfer->getErpOrderReference())
            ->setErpOrderExternalReference($restErpOrderCancellationAttributesTransfer->getErpOrderExternalReference());

        return $this->erpOrderCancellationFacade->createErpOrderCancellation($erpOrderCancellationTransfer)->getErpOrderCancellation();
    }
}
