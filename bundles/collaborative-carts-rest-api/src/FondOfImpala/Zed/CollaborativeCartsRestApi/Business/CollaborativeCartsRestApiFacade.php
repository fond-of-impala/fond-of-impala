<?php

namespace FondOfImpala\Zed\CollaborativeCartsRestApi\Business;

use Generated\Shared\Transfer\RestClaimCartRequestTransfer;
use Generated\Shared\Transfer\RestClaimCartResponseTransfer;
use Generated\Shared\Transfer\RestReleaseCartRequestTransfer;
use Generated\Shared\Transfer\RestReleaseCartResponseTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\CollaborativeCartsRestApi\Business\CollaborativeCartsRestApiBusinessFactory getFactory()
 */
class CollaborativeCartsRestApiFacade extends AbstractFacade implements CollaborativeCartsRestApiFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestClaimCartRequestTransfer $restClaimCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestClaimCartResponseTransfer
     */
    public function claimCart(
        RestClaimCartRequestTransfer $restClaimCartRequestTransfer
    ): RestClaimCartResponseTransfer {
        return $this->getFactory()->createCartClaimer()->claim($restClaimCartRequestTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestReleaseCartRequestTransfer $restReleaseCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestReleaseCartResponseTransfer
     */
    public function releaseCart(
        RestReleaseCartRequestTransfer $restReleaseCartRequestTransfer
    ): RestReleaseCartResponseTransfer {
        return $this->getFactory()->createCartReleaser()->release($restReleaseCartRequestTransfer);
    }
}
