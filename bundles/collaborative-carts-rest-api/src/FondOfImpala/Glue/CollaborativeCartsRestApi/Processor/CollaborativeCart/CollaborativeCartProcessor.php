<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\CollaborativeCart;

use FondOfImpala\Glue\CollaborativeCartsRestApi\CollaborativeCartsRestApiConfig;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Builder\CollaborativeCartRestResponseBuilderInterface;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Claimer\CartClaimerInterface;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Releaser\CartReleaserInterface;
use Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CollaborativeCartProcessor implements CollaborativeCartProcessorInterface
{
    protected CollaborativeCartRestResponseBuilderInterface $collaborativeCartRestResponseBuilder;

    protected CartClaimerInterface $cartClaimer;

    protected CartReleaserInterface $cartReleaser;

    /**
     * @param \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Builder\CollaborativeCartRestResponseBuilderInterface $collaborativeCartRestResponseBuilder
     * @param \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Claimer\CartClaimerInterface $cartClaimer
     * @param \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Releaser\CartReleaserInterface $cartReleaser
     */
    public function __construct(
        CollaborativeCartRestResponseBuilderInterface $collaborativeCartRestResponseBuilder,
        CartClaimerInterface $cartClaimer,
        CartReleaserInterface $cartReleaser
    ) {
        $this->collaborativeCartRestResponseBuilder = $collaborativeCartRestResponseBuilder;
        $this->cartClaimer = $cartClaimer;
        $this->cartReleaser = $cartReleaser;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer $restCollaborativeCartsRequestAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function process(
        RestRequestInterface $restRequest,
        RestCollaborativeCartsRequestAttributesTransfer $restCollaborativeCartsRequestAttributesTransfer
    ): RestResponseInterface {
        if ($restCollaborativeCartsRequestAttributesTransfer->getCartId() === null) {
            return $this->collaborativeCartRestResponseBuilder->createCartIdMissingErrorResponse();
        }

        return match ($restCollaborativeCartsRequestAttributesTransfer->getAction()) {
            CollaborativeCartsRestApiConfig::ACTION_CLAIM => $this->cartClaimer->claim($restRequest, $restCollaborativeCartsRequestAttributesTransfer),
            CollaborativeCartsRestApiConfig::ACTION_RELEASE => $this->cartReleaser->release($restRequest, $restCollaborativeCartsRequestAttributesTransfer),
            default => $this->collaborativeCartRestResponseBuilder->createInvalidActionErrorResponse(),
        };
    }
}
