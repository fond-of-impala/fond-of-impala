<?php

namespace FondOfImpala\Client\CollaborativeCartsRestApi\Zed;

use FondOfImpala\Client\CollaborativeCartsRestApi\Dependency\Client\CollaborativeCartsRestApiToZedRequestClientInterface;
use Generated\Shared\Transfer\RestClaimCartRequestTransfer;
use Generated\Shared\Transfer\RestClaimCartResponseTransfer;
use Generated\Shared\Transfer\RestReleaseCartRequestTransfer;
use Generated\Shared\Transfer\RestReleaseCartResponseTransfer;

class CollaborativeCartsRestApiStub implements CollaborativeCartsRestApiStubInterface
{
    /**
     * @var \FondOfImpala\Client\CollaborativeCartsRestApi\Dependency\Client\CollaborativeCartsRestApiToZedRequestClientInterface
     */
    protected $zedRequestClient;

    /**
     * @param \FondOfImpala\Client\CollaborativeCartsRestApi\Dependency\Client\CollaborativeCartsRestApiToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(CollaborativeCartsRestApiToZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param \Generated\Shared\Transfer\RestClaimCartRequestTransfer $restClaimCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestClaimCartResponseTransfer
     */
    public function claimCart(
        RestClaimCartRequestTransfer $restClaimCartRequestTransfer
    ): RestClaimCartResponseTransfer {
        /** @var \Generated\Shared\Transfer\RestClaimCartResponseTransfer $restClaimCartResponseTransfer */
        $restClaimCartResponseTransfer = $this->zedRequestClient->call(
            '/collaborative-carts-rest-api/gateway/claim-cart',
            $restClaimCartRequestTransfer,
        );

        return $restClaimCartResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestReleaseCartRequestTransfer $restReleaseCartRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestReleaseCartResponseTransfer
     */
    public function releaseCart(RestReleaseCartRequestTransfer $restReleaseCartRequestTransfer): RestReleaseCartResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\RestReleaseCartResponseTransfer $restReleaseCartResponseTransfer */
        $restReleaseCartResponseTransfer = $this->zedRequestClient->call(
            '/collaborative-carts-rest-api/gateway/release-cart',
            $restReleaseCartRequestTransfer,
        );

        return $restReleaseCartResponseTransfer;
    }
}
