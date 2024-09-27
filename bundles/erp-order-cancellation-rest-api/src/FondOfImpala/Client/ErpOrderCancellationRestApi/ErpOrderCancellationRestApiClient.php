<?php

namespace FondOfImpala\Client\ErpOrderCancellationRestApi;

use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationCollectionResponseTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfImpala\Client\ErpOrderCancellationRestApi\ErpOrderCancellationRestApiFactory getFactory()
 */
class ErpOrderCancellationRestApiClient extends AbstractClient implements ErpOrderCancellationRestApiClientInterface
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
    ): RestErpOrderCancellationResponseTransfer|RestErrorMessageTransfer {
        return $this->getFactory()->createZedErpOrderCancellationRestApiStub()->addErpOrderCancellation($restErpOrderCancellationRequestTransfer);
    }

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
    ): RestErpOrderCancellationCollectionResponseTransfer|RestErrorMessageTransfer {
        return $this->getFactory()->createZedErpOrderCancellationRestApiStub()->getErpOrderCancellation($restErpOrderCancellationRequestTransfer);
    }

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
    ): RestErpOrderCancellationResponseTransfer|RestErrorMessageTransfer {
        return $this->getFactory()->createZedErpOrderCancellationRestApiStub()->patchErpOrderCancellation($restErpOrderCancellationRequestTransfer);
    }

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
    ): RestErpOrderCancellationResponseTransfer|RestErrorMessageTransfer {
        return $this->getFactory()->createZedErpOrderCancellationRestApiStub()->deleteErpOrderCancellation($restErpOrderCancellationRequestTransfer);
    }
}
