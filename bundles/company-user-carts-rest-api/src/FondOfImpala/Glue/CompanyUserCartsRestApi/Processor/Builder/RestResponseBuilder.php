<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Builder;

use FondOfImpala\Glue\CompanyUserCartsRestApi\CompanyUserCartsRestApiConfig;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCartsAttributesMapperInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestItemsAttributesMapperInterface;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestLinkInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class RestResponseBuilder implements RestResponseBuilderInterface
{
    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCartsAttributesMapperInterface
     */
    protected $restCartsAttributesMapper;

    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestItemsAttributesMapperInterface
     */
    protected $restItemsAttributesMapper;

    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilder;

    /**
     * @param \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCartsAttributesMapperInterface $restCartsAttributesMapper
     * @param \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestItemsAttributesMapperInterface $restItemsAttributesMapper
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     */
    public function __construct(
        RestCartsAttributesMapperInterface $restCartsAttributesMapper,
        RestItemsAttributesMapperInterface $restItemsAttributesMapper,
        RestResourceBuilderInterface $restResourceBuilder
    ) {
        $this->restCartsAttributesMapper = $restCartsAttributesMapper;
        $this->restItemsAttributesMapper = $restItemsAttributesMapper;
        $this->restResourceBuilder = $restResourceBuilder;
    }

    /**
     * @param array<\Generated\Shared\Transfer\QuoteErrorTransfer> $quoteErrorTransfers
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function buildErrorRestResponse(array $quoteErrorTransfers): RestResponseInterface
    {
        $restResponse = $this->restResourceBuilder
            ->createRestResponse();

        if (count($quoteErrorTransfers) === 0) {
            $restErrorMessageTransfer = (new RestErrorMessageTransfer())
                ->setCode(CompanyUserCartsRestApiConfig::RESPONSE_CODE_OTHER)
                ->setStatus(Response::HTTP_BAD_REQUEST)
                ->setDetail('Undefined');

            return $restResponse->addError($restErrorMessageTransfer);
        }

        foreach ($quoteErrorTransfers as $quoteErrorTransfer) {
            $restErrorMessageTransfer = (new RestErrorMessageTransfer())
                ->setCode(CompanyUserCartsRestApiConfig::RESPONSE_CODE_OTHER)
                ->setStatus(Response::HTTP_BAD_REQUEST)
                ->setDetail($quoteErrorTransfer->getMessage());

            $restResponse->addError($restErrorMessageTransfer);
        }

        return $restResponse;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function buildRestResponse(QuoteTransfer $quoteTransfer): RestResponseInterface
    {
        $restResource = $this->restResourceBuilder->createRestResource(
            CompanyUserCartsRestApiConfig::RESOURCE_COMPANY_USER_CARTS,
            $quoteTransfer->getUuid(),
            $this->restCartsAttributesMapper->fromQuote($quoteTransfer),
        )->setPayload($quoteTransfer);

        foreach ($quoteTransfer->getItems() as $itemTransfer) {
            $relatedRestResource = $this->restResourceBuilder->createRestResource(
                CompanyUserCartsRestApiConfig::RESOURCE_CART_ITEMS,
                $itemTransfer->getGroupKey(),
                $this->restItemsAttributesMapper->fromItem($itemTransfer),
            )->addLink(
                RestLinkInterface::LINK_SELF,
                sprintf(
                    '%s/%s/%s/%s',
                    CompanyUserCartsRestApiConfig::RESOURCE_CARTS,
                    $restResource->getId(),
                    CompanyUserCartsRestApiConfig::RESOURCE_CART_ITEMS,
                    $itemTransfer->getGroupKey(),
                ),
            );

            $restResource->addRelationship($relatedRestResource);
        }

        $restResource->addLink(
            RestLinkInterface::LINK_SELF,
            sprintf(
                CompanyUserCartsRestApiConfig::FORMAT_SELF_LINK_CART_RESOURCE,
                CompanyUserCartsRestApiConfig::RESOURCE_COMPANY_USERS,
                $quoteTransfer->getCompanyUserReference(),
                CompanyUserCartsRestApiConfig::RESOURCE_COMPANY_USER_CARTS,
                $quoteTransfer->getUuid(),
            ),
        );

        return $this->restResourceBuilder->createRestResponse()
            ->addResource($restResource);
    }

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function buildEmptyRestResponse(): RestResponseInterface
    {
        return $this->restResourceBuilder->createRestResponse();
    }

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function buildCartIdIsMissingRestResponse(): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode(CompanyUserCartsRestApiConfig::RESPONSE_CODE_CART_ID_IS_MISSING)
            ->setStatus(Response::HTTP_BAD_REQUEST)
            ->setDetail(CompanyUserCartsRestApiConfig::RESPONSE_DETAIL_CART_ID_IS_MISSING);

        return $this->restResourceBuilder
            ->createRestResponse()
            ->addError($restErrorMessageTransfer);
    }
}
