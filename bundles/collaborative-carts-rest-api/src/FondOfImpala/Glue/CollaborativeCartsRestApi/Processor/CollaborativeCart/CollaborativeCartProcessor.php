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
    /**
     * @var \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Builder\CollaborativeCartRestResponseBuilderInterface
     */
    protected $collaborativeCartRestResponseBuilder;

    /**
     * @var \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Claimer\CartClaimerInterface
     */
    protected $cartClaimer;

    /**
     * @var \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Releaser\CartReleaserInterface
     */
    protected $cartReleaser;

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

        switch ($restCollaborativeCartsRequestAttributesTransfer->getAction()) {
            case CollaborativeCartsRestApiConfig::ACTION_CLAIM:
                return $this->cartClaimer->claim($restRequest, $restCollaborativeCartsRequestAttributesTransfer);
            case CollaborativeCartsRestApiConfig::ACTION_RELEASE:
                return $this->cartReleaser->release($restRequest, $restCollaborativeCartsRequestAttributesTransfer);
            default:
                return $this->collaborativeCartRestResponseBuilder->createInvalidActionErrorResponse();
        }
    }
}
