<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Business;

use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationCollectionResponseTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\ErpOrderCancellationRestApiBusinessFactory getFactory()
 */
class ErpOrderCancellationRestApiFacade extends AbstractFacade implements ErpOrderCancellationRestApiFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer|\Generated\Shared\Transfer\RestErrorMessageTransfer
     */
    public function addErpOrderCancellation(
        RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
    ): RestErpOrderCancellationResponseTransfer|RestErrorMessageTransfer {
        return $this->getFactory()
            ->createCancellationManager()
            ->addErpOrderCancellation($restErpOrderCancellationRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationCollectionResponseTransfer|\Generated\Shared\Transfer\RestErrorMessageTransfer
     */
    public function getErpOrderCancellation(
        RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
    ): RestErpOrderCancellationCollectionResponseTransfer|RestErrorMessageTransfer {
        return $this->getFactory()
            ->createCancellationManager()
            ->getErpOrderCancellation($restErpOrderCancellationRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer|\Generated\Shared\Transfer\RestErrorMessageTransfer
     */
    public function updateErpOrderCancellation(
        RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
    ): RestErpOrderCancellationResponseTransfer|RestErrorMessageTransfer {
        return $this->getFactory()
            ->createCancellationManager()
            ->updateErpOrderCancellation($restErpOrderCancellationRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer|\Generated\Shared\Transfer\RestErrorMessageTransfer
     */
    public function deleteErpOrderCancellation(
        RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
    ): RestErpOrderCancellationResponseTransfer|RestErrorMessageTransfer {
        return $this->getFactory()
            ->createCancellationManager()
            ->deleteErpOrderCancellation($restErpOrderCancellationRequestTransfer);
    }
}
