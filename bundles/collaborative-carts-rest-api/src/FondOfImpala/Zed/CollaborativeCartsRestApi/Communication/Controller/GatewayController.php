<?php

namespace FondOfImpala\Zed\CollaborativeCartsRestApi\Communication\Controller;

use Generated\Shared\Transfer\RestClaimCartRequestTransfer;
use Generated\Shared\Transfer\RestClaimCartResponseTransfer;
use Generated\Shared\Transfer\RestReleaseCartRequestTransfer;
use Generated\Shared\Transfer\RestReleaseCartResponseTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \FondOfImpala\Zed\CollaborativeCartsRestApi\Business\CollaborativeCartsRestApiFacade getFacade()
 */
class GatewayController extends AbstractGatewayController
{
    /**
     * @param \Generated\Shared\Transfer\RestClaimCartRequestTransfer $restClaimCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestClaimCartResponseTransfer
     */
    public function claimCartAction(
        RestClaimCartRequestTransfer $restClaimCartRequestTransfer
    ): RestClaimCartResponseTransfer {
        return $this->getFacade()->claimCart($restClaimCartRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RestReleaseCartRequestTransfer $restReleaseCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestReleaseCartResponseTransfer
     */
    public function releaseCartAction(
        RestReleaseCartRequestTransfer $restReleaseCartRequestTransfer
    ): RestReleaseCartResponseTransfer {
        return $this->getFacade()->releaseCart($restReleaseCartRequestTransfer);
    }
}
