<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Releaser;

use FondOfImpala\Client\CollaborativeCartsRestApi\CollaborativeCartsRestApiClientInterface;
use FondOfImpala\Glue\CollaborativeCartsRestApi\CollaborativeCartsRestApiConfig;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Builder\CollaborativeCartRestResponseBuilderInterface;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Expander\RestReleaseCartRequestExpanderInterface;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper\RestReleaseCartRequestMapperInterface;
use Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CartReleaser implements CartReleaserInterface
{
    protected RestReleaseCartRequestMapperInterface $restReleaseCartRequestMapper;

    protected RestReleaseCartRequestExpanderInterface $restReleaseCartRequestExpander;

    protected CollaborativeCartRestResponseBuilderInterface $collaborativeCartRestResponseBuilder;

    protected CollaborativeCartsRestApiClientInterface $client;

    /**
     * @param \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper\RestReleaseCartRequestMapperInterface $restReleaseCartRequestMapper
     * @param \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Expander\RestReleaseCartRequestExpanderInterface $restReleaseCartRequestExpander
     * @param \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Builder\CollaborativeCartRestResponseBuilderInterface $collaborativeCartRestResponseBuilder
     * @param \FondOfImpala\Client\CollaborativeCartsRestApi\CollaborativeCartsRestApiClientInterface $client
     */
    public function __construct(
        RestReleaseCartRequestMapperInterface $restReleaseCartRequestMapper,
        RestReleaseCartRequestExpanderInterface $restReleaseCartRequestExpander,
        CollaborativeCartRestResponseBuilderInterface $collaborativeCartRestResponseBuilder,
        CollaborativeCartsRestApiClientInterface $client
    ) {
        $this->collaborativeCartRestResponseBuilder = $collaborativeCartRestResponseBuilder;
        $this->restReleaseCartRequestMapper = $restReleaseCartRequestMapper;
        $this->restReleaseCartRequestExpander = $restReleaseCartRequestExpander;
        $this->client = $client;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer $restCollaborativeCartsRequestAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function release(
        RestRequestInterface $restRequest,
        RestCollaborativeCartsRequestAttributesTransfer $restCollaborativeCartsRequestAttributesTransfer
    ): RestResponseInterface {
        $restReleaseCartRequestTransfer = $this->restReleaseCartRequestMapper->fromRestCollaborativeCartsRequestAttributes(
            $restCollaborativeCartsRequestAttributesTransfer,
        );

        $restReleaseCartRequestTransfer = $this->restReleaseCartRequestExpander->expand(
            $restReleaseCartRequestTransfer,
            $restRequest,
        );

        $restReleaseCartResponseTransfer = $this->client->releaseCart($restReleaseCartRequestTransfer);
        $quoteTransfer = $restReleaseCartResponseTransfer->getQuote();

        if ($quoteTransfer === null || $restReleaseCartResponseTransfer->getIsSuccess() === false) {
            return $this->collaborativeCartRestResponseBuilder->createNotReleasedErrorResponse();
        }

        return $this->collaborativeCartRestResponseBuilder->createRestResponse(
            CollaborativeCartsRestApiConfig::ACTION_RELEASE,
            $quoteTransfer,
        );
    }
}
