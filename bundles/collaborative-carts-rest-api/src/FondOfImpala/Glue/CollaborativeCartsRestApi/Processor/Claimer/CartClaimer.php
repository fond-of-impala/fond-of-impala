<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Claimer;

use FondOfImpala\Client\CollaborativeCartsRestApi\CollaborativeCartsRestApiClientInterface;
use FondOfImpala\Glue\CollaborativeCartsRestApi\CollaborativeCartsRestApiConfig;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Builder\CollaborativeCartRestResponseBuilderInterface;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Expander\RestClaimCartRequestExpanderInterface;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper\RestClaimCartRequestMapperInterface;
use Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CartClaimer implements CartClaimerInterface
{
    /**
     * @var \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper\RestClaimCartRequestMapperInterface
     */
    protected $restClaimCartRequestMapper;

    /**
     * @var \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Expander\RestClaimCartRequestExpanderInterface
     */
    protected $restClaimCartRequestExpander;

    /**
     * @var \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Builder\CollaborativeCartRestResponseBuilderInterface
     */
    protected $collaborativeCartRestResponseBuilder;

    /**
     * @var \FondOfImpala\Client\CollaborativeCartsRestApi\CollaborativeCartsRestApiClientInterface
     */
    protected $client;

    /**
     * @param \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper\RestClaimCartRequestMapperInterface $restClaimCartRequestMapper
     * @param \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Expander\RestClaimCartRequestExpanderInterface $restClaimCartRequestExpander
     * @param \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Builder\CollaborativeCartRestResponseBuilderInterface $collaborativeCartRestResponseBuilder
     * @param \FondOfImpala\Client\CollaborativeCartsRestApi\CollaborativeCartsRestApiClientInterface $client
     */
    public function __construct(
        RestClaimCartRequestMapperInterface $restClaimCartRequestMapper,
        RestClaimCartRequestExpanderInterface $restClaimCartRequestExpander,
        CollaborativeCartRestResponseBuilderInterface $collaborativeCartRestResponseBuilder,
        CollaborativeCartsRestApiClientInterface $client
    ) {
        $this->collaborativeCartRestResponseBuilder = $collaborativeCartRestResponseBuilder;
        $this->restClaimCartRequestMapper = $restClaimCartRequestMapper;
        $this->restClaimCartRequestExpander = $restClaimCartRequestExpander;
        $this->client = $client;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer $restCollaborativeCartsRequestAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function claim(
        RestRequestInterface $restRequest,
        RestCollaborativeCartsRequestAttributesTransfer $restCollaborativeCartsRequestAttributesTransfer
    ): RestResponseInterface {
        $restClaimCartRequestTransfer = $this->restClaimCartRequestMapper->fromRestCollaborativeCartsRequestAttributes(
            $restCollaborativeCartsRequestAttributesTransfer,
        );

        $restClaimCartRequestTransfer = $this->restClaimCartRequestExpander->expand(
            $restClaimCartRequestTransfer,
            $restRequest,
        );

        $restClaimCartResponseTransfer = $this->client->claimCart($restClaimCartRequestTransfer);
        $quoteTransfer = $restClaimCartResponseTransfer->getQuote();

        if ($quoteTransfer === null || $restClaimCartResponseTransfer->getIsSuccess() === false) {
            return $this->collaborativeCartRestResponseBuilder->createNotClaimedErrorResponse();
        }

        return $this->collaborativeCartRestResponseBuilder->createRestResponse(
            CollaborativeCartsRestApiConfig::ACTION_CLAIM,
            $quoteTransfer,
        );
    }
}
