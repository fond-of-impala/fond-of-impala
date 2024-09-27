<?php

namespace FondOfImpala\Client\ErpOrderCancellationRestApi\Zed;

use FondOfImpala\Client\ErpOrderCancellationRestApi\Dependency\Client\ErpOrderCancellationRestApiToZedRequestClientInterface;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationCollectionResponseTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer;

class ErpOrderCancellationRestApiStub implements ErpOrderCancellationRestApiStubInterface
{
    /**
     * @var string
     */
    public const ADD_ERP_ORDER_CANCELLATION = '/erp-order-cancellation-rest-api/gateway/add-erp-order-cancellation';

    /**
     * @var string
     */
    public const GET_ERP_ORDER_CANCELLATION = '/erp-order-cancellation-rest-api/gateway/get-erp-order-cancellation';

    /**
     * @var string
     */
    public const PATCH_ERP_ORDER_CANCELLATION = '/erp-order-cancellation-rest-api/gateway/patch-erp-order-cancellation';

    /**
     * @var string
     */
    public const DELETE_ERP_ORDER_CANCELLATION = '/erp-order-cancellation-rest-api/gateway/delete-erp-order-cancellation';

    /**
     * @var \FondOfImpala\Client\ErpOrderCancellationRestApi\Dependency\Client\ErpOrderCancellationRestApiToZedRequestClientInterface
     */
    protected $zedRequestClient;

    /**
     * @param \FondOfImpala\Client\ErpOrderCancellationRestApi\Dependency\Client\ErpOrderCancellationRestApiToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(ErpOrderCancellationRestApiToZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer|\Generated\Shared\Transfer\RestErrorMessageTransfer
     */
    public function addErpOrderCancellation(
        RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
    ): RestErpOrderCancellationResponseTransfer|RestErrorMessageTransfer {
        /** @var \Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer|\Generated\Shared\Transfer\RestErrorMessageTransfer $erpOrderCancellationRestResponseTransfer */
        $erpOrderCancellationRestResponseTransfer = $this->zedRequestClient->call(static::ADD_ERP_ORDER_CANCELLATION, $restErpOrderCancellationRequestTransfer);

        return $erpOrderCancellationRestResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationCollectionResponseTransfer|\Generated\Shared\Transfer\RestErrorMessageTransfer
     */
    public function getErpOrderCancellation(
        RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
    ): RestErpOrderCancellationCollectionResponseTransfer|RestErrorMessageTransfer {
        /** @var \Generated\Shared\Transfer\RestErpOrderCancellationCollectionResponseTransfer|\Generated\Shared\Transfer\RestErrorMessageTransfer $erpOrderCancellationRestResponseTransfer */
        $erpOrderCancellationRestResponseTransfer = $this->zedRequestClient->call(static::GET_ERP_ORDER_CANCELLATION, $restErpOrderCancellationRequestTransfer);

        return $erpOrderCancellationRestResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer|\Generated\Shared\Transfer\RestErrorMessageTransfer
     */
    public function patchErpOrderCancellation(
        RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
    ): RestErpOrderCancellationResponseTransfer|RestErrorMessageTransfer {
        /** @var \Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer|\Generated\Shared\Transfer\RestErrorMessageTransfer $erpOrderCancellationRestResponseTransfer */
        $erpOrderCancellationRestResponseTransfer = $this->zedRequestClient->call(static::PATCH_ERP_ORDER_CANCELLATION, $restErpOrderCancellationRequestTransfer);

        return $erpOrderCancellationRestResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer|\Generated\Shared\Transfer\RestErrorMessageTransfer
     */
    public function deleteErpOrderCancellation(
        RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
    ): RestErpOrderCancellationResponseTransfer|RestErrorMessageTransfer {
        /** @var \Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer|\Generated\Shared\Transfer\RestErrorMessageTransfer $erpOrderCancellationRestResponseTransfer */
        $erpOrderCancellationRestResponseTransfer = $this->zedRequestClient->call(static::DELETE_ERP_ORDER_CANCELLATION, $restErpOrderCancellationRequestTransfer);

        return $erpOrderCancellationRestResponseTransfer;
    }
}
