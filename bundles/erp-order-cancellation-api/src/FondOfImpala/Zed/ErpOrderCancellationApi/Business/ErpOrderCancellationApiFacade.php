<?php

namespace FondOfImpala\Zed\ErpOrderCancellationApi\Business;

use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellationApi\Persistence\ErpOrderCancellationApiRepositoryInterface getRepository()
 * @method \FondOfImpala\Zed\ErpOrderCancellationApi\Business\ErpOrderCancellationApiBusinessFactory getFactory()
 */
class ErpOrderCancellationApiFacade extends AbstractFacade implements ErpOrderCancellationApiFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function createErpOrderCancellation(ApiDataTransfer $apiDataTransfer): ApiItemTransfer
    {
        return $this->getFactory()
            ->createErpOrderCancellationApi()
            ->create($apiDataTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idErpOrderCancellation
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function updateErpOrderCancellation(int $idErpOrderCancellation, ApiDataTransfer $apiDataTransfer): ApiItemTransfer
    {
        return $this->getFactory()
            ->createErpOrderCancellationApi()
            ->update($idErpOrderCancellation, $apiDataTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idErpOrderCancellation
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function getErpOrderCancellation(int $idErpOrderCancellation): ApiItemTransfer
    {
        return $this->getFactory()
            ->createErpOrderCancellationApi()
            ->get($idErpOrderCancellation);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ApiCollectionTransfer
     */
    public function findErpOrderCancellations(ApiRequestTransfer $apiRequestTransfer): ApiCollectionTransfer
    {
        return $this->getFactory()
            ->createErpOrderCancellationApi()
            ->find($apiRequestTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idErpOrderCancellation
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function deleteErpOrderCancellation(int $idErpOrderCancellation): ApiItemTransfer
    {
        return $this->getFactory()
            ->createErpOrderCancellationApi()
            ->delete($idErpOrderCancellation);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return array<\Generated\Shared\Transfer\ApiValidationErrorTransfer>
     */
    public function validateErpOrderCancellation(ApiRequestTransfer $apiRequestTransfer): array
    {
        return $this->getFactory()
            ->createErpOrderCancellationApiValidator()
            ->validate($apiRequestTransfer);
    }
}
