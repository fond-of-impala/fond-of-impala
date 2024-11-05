<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Business;

use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationCollectionResponseTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;

interface ErpOrderCancellationRestApiFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer|\Generated\Shared\Transfer\RestErrorMessageTransfer
     */
    public function addErpOrderCancellation(
        RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
    ): RestErpOrderCancellationResponseTransfer|RestErrorMessageTransfer;

    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationCollectionResponseTransfer|\Generated\Shared\Transfer\RestErrorMessageTransfer
     */
    public function getErpOrderCancellation(
        RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
    ): RestErpOrderCancellationCollectionResponseTransfer|RestErrorMessageTransfer;

    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer|\Generated\Shared\Transfer\RestErrorMessageTransfer
     */
    public function updateErpOrderCancellation(
        RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
    ): RestErpOrderCancellationResponseTransfer|RestErrorMessageTransfer;

    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer|\Generated\Shared\Transfer\RestErrorMessageTransfer
     */
    public function deleteErpOrderCancellation(
        RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
    ): RestErpOrderCancellationResponseTransfer|RestErrorMessageTransfer;

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function updateErpOrderCancellationAmount(
        ErpOrderCancellationTransfer $erpOrderCancellationTransfer
    ): ErpOrderCancellationTransfer;
}
