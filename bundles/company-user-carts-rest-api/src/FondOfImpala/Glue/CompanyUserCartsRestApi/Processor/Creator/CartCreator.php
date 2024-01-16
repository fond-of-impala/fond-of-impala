<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Creator;

use FondOfImpala\Client\CompanyUserCartsRestApi\CompanyUserCartsRestApiClientInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Builder\RestResponseBuilderInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Expander\RestCartItemExpanderInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCompanyUserCartsRequestMapperInterface;
use Generated\Shared\Transfer\RestCartsRequestAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CartCreator implements CartCreatorInterface
{
    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCompanyUserCartsRequestMapperInterface
     */
    protected $restCompanyUserCartsRequestMapper;

    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Expander\RestCartItemExpanderInterface
     */
    protected $restCartItemExpander;

    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Builder\RestResponseBuilderInterface
     */
    protected $restResponseBuilder;

    /**
     * @var \FondOfImpala\Client\CompanyUserCartsRestApi\CompanyUserCartsRestApiClientInterface
     */
    protected $client;

    /**
     * @param \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCompanyUserCartsRequestMapperInterface $restCompanyUserCartsRequestMapper
     * @param \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Expander\RestCartItemExpanderInterface $restCartItemExpander
     * @param \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Builder\RestResponseBuilderInterface $restResponseBuilder
     * @param \FondOfImpala\Client\CompanyUserCartsRestApi\CompanyUserCartsRestApiClientInterface $client
     */
    public function __construct(
        RestCompanyUserCartsRequestMapperInterface $restCompanyUserCartsRequestMapper,
        RestCartItemExpanderInterface $restCartItemExpander,
        RestResponseBuilderInterface $restResponseBuilder,
        CompanyUserCartsRestApiClientInterface $client
    ) {
        $this->restCompanyUserCartsRequestMapper = $restCompanyUserCartsRequestMapper;
        $this->restCartItemExpander = $restCartItemExpander;
        $this->restResponseBuilder = $restResponseBuilder;
        $this->client = $client;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestCartsRequestAttributesTransfer $restCartsRequestAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function create(
        RestRequestInterface $restRequest,
        RestCartsRequestAttributesTransfer $restCartsRequestAttributesTransfer
    ): RestResponseInterface {
        $restCartItemTransfers = $restCartsRequestAttributesTransfer->getItems();

        foreach ($restCartItemTransfers as $index => $restCartItemTransfer) {
            $restCartItemTransfers->offsetSet($index, $this->restCartItemExpander->expand($restCartItemTransfer));
        }

        $restCompanyUserCartsRequestTransfer = $this->restCompanyUserCartsRequestMapper->fromRestRequest($restRequest)
            ->setCart($restCartsRequestAttributesTransfer);

        $restCompanyUserCartsResponseTransfer = $this->client->createQuoteByRestCompanyUserCartsRequest(
            $restCompanyUserCartsRequestTransfer,
        );

        $quoteTransfer = $restCompanyUserCartsResponseTransfer->getQuote();

        if ($quoteTransfer === null || $restCompanyUserCartsResponseTransfer->getIsSuccessful() === false) {
            return $this->restResponseBuilder->buildErrorRestResponse(
                $restCompanyUserCartsResponseTransfer->getErrors()->getArrayCopy(),
            );
        }

        return $this->restResponseBuilder->buildRestResponse($restCompanyUserCartsResponseTransfer->getQuote());
    }
}
