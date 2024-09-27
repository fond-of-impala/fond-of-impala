<?php

namespace FondOfImpala\Client\ErpOrderCancellationRestApi;

use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationCollectionResponseTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer;

interface ErpOrderCancellationRestApiClientInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer|\Generated\Shared\Transfer\RestErrorMessageTransfer
     */
    public function addErpOrderCancellation(
        RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
    ): RestErpOrderCancellationResponseTransfer|RestErrorMessageTransfer;

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationCollectionResponseTransfer|\Generated\Shared\Transfer\RestErrorMessageTransfer
     */
    public function getErpOrderCancellation(
        RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
    ): RestErpOrderCancellationCollectionResponseTransfer|RestErrorMessageTransfer;

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer|\Generated\Shared\Transfer\RestErrorMessageTransfer
     */
    public function patchErpOrderCancellation(
        RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
    ): RestErpOrderCancellationResponseTransfer|RestErrorMessageTransfer;

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer|\Generated\Shared\Transfer\RestErrorMessageTransfer
     */
    public function deleteErpOrderCancellation(
        RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
    ): RestErpOrderCancellationResponseTransfer|RestErrorMessageTransfer;
}
