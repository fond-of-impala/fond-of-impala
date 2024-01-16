<?php

namespace FondOfImpala\Client\CollaborativeCartsRestApi;

use Generated\Shared\Transfer\RestClaimCartRequestTransfer;
use Generated\Shared\Transfer\RestClaimCartResponseTransfer;
use Generated\Shared\Transfer\RestReleaseCartRequestTransfer;
use Generated\Shared\Transfer\RestReleaseCartResponseTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfImpala\Client\CollaborativeCartsRestApi\CollaborativeCartsRestApiFactory getFactory()
 */
class CollaborativeCartsRestApiClient extends AbstractClient implements CollaborativeCartsRestApiClientInterface
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
        return $this->getFactory()
            ->createCollaborativeCartsRestApiStub()
            ->claimCart($restClaimCartRequestTransfer);
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
        return $this->getFactory()
            ->createCollaborativeCartsRestApiStub()
            ->releaseCart($restReleaseCartRequestTransfer);
    }
}
