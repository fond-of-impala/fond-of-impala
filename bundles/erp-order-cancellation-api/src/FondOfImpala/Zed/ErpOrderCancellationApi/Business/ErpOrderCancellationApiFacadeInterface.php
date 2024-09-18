<?php

namespace FondOfImpala\Zed\ErpOrderCancellationApi\Business;

use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;

interface ErpOrderCancellationApiFacadeInterface
{
    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function createErpOrderCancellation(ApiDataTransfer $apiDataTransfer): ApiItemTransfer;

    /**
     * @api
     *
     * @param int $idErpOrderCancellation
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function updateErpOrderCancellation(int $idErpOrderCancellation, ApiDataTransfer $apiDataTransfer): ApiItemTransfer;

    /**
     * @api
     *
     * @param int $idErpOrderCancellation
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function getErpOrderCancellation(int $idErpOrderCancellation): ApiItemTransfer;

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ApiCollectionTransfer
     */
    public function findErpOrderCancellations(ApiRequestTransfer $apiRequestTransfer): ApiCollectionTransfer;

    /**
     * @api
     *
     * @param int $idErpOrderCancellation
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function deleteErpOrderCancellation(int $idErpOrderCancellation): ApiItemTransfer;

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return array<\Generated\Shared\Transfer\ApiValidationErrorTransfer>
     */
    public function validateErpOrderCancellation(ApiRequestTransfer $apiRequestTransfer): array;
}
