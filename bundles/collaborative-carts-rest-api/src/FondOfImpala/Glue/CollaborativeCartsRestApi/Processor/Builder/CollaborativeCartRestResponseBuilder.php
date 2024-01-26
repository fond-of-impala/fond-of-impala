<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Builder;

use FondOfImpala\Glue\CollaborativeCartsRestApi\CollaborativeCartsRestApiConfig;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper\RestCollaborativeCartsResponseAttributesMapperInterface;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class CollaborativeCartRestResponseBuilder implements CollaborativeCartRestResponseBuilderInterface
{
    protected RestResourceBuilderInterface $restResourceBuilder;

    protected RestCollaborativeCartsResponseAttributesMapperInterface $restCollaborativeCartsResponseAttributesMapper;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper\RestCollaborativeCartsResponseAttributesMapperInterface $restCollaborativeCartsResponseAttributesMapper
     */
    public function __construct(
        RestResourceBuilderInterface $restResourceBuilder,
        RestCollaborativeCartsResponseAttributesMapperInterface $restCollaborativeCartsResponseAttributesMapper
    ) {
        $this->restResourceBuilder = $restResourceBuilder;
        $this->restCollaborativeCartsResponseAttributesMapper = $restCollaborativeCartsResponseAttributesMapper;
    }

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createInvalidActionErrorResponse(): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setStatus(Response::HTTP_BAD_REQUEST)
            ->setCode(CollaborativeCartsRestApiConfig::RESPONSE_CODE_INVALID_ACTION)
            ->setDetail(CollaborativeCartsRestApiConfig::RESPONSE_DETAIL_INVALID_ACTION);

        return $this->restResourceBuilder
            ->createRestResponse()
            ->addError($restErrorMessageTransfer);
    }

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createCartIdMissingErrorResponse(): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setStatus(Response::HTTP_BAD_REQUEST)
            ->setCode(CollaborativeCartsRestApiConfig::RESPONSE_CODE_CART_ID_MISSING)
            ->setDetail(CollaborativeCartsRestApiConfig::RESPONSE_DETAIL_CART_ID_MISSING);

        return $this->restResourceBuilder
            ->createRestResponse()
            ->addError($restErrorMessageTransfer);
    }

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createNotClaimedErrorResponse(): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->setCode(CollaborativeCartsRestApiConfig::RESPONSE_CODE_NOT_CLAIMED)
            ->setDetail(CollaborativeCartsRestApiConfig::RESPONSE_DETAIL_NOT_CLAIMED);

        return $this->restResourceBuilder
            ->createRestResponse()
            ->addError($restErrorMessageTransfer);
    }

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createNotReleasedErrorResponse(): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->setCode(CollaborativeCartsRestApiConfig::RESPONSE_DETAIL_NOT_RELEASED)
            ->setDetail(CollaborativeCartsRestApiConfig::RESPONSE_DETAIL_NOT_RELEASED);

        return $this->restResourceBuilder
            ->createRestResponse()
            ->addError($restErrorMessageTransfer);
    }

    /**
     * @param string $action
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createRestResponse(string $action, QuoteTransfer $quoteTransfer): RestResponseInterface
    {
        $restCollaborativeCartsResponseAttributesTransfer = $this->restCollaborativeCartsResponseAttributesMapper
            ->fromQuote($quoteTransfer)
            ->setAction($action);

        $restResource = $this->restResourceBuilder->createRestResource(
            CollaborativeCartsRestApiConfig::RESOURCE_COLLABORATIVE_CARTS,
            null,
            $restCollaborativeCartsResponseAttributesTransfer,
        )->setPayload($restCollaborativeCartsResponseAttributesTransfer);

        return $this->restResourceBuilder
            ->createRestResponse()
            ->addResource($restResource)
            ->setStatus(Response::HTTP_CREATED);
    }
}
