<?php

namespace FondOfImpala\Glue\ErpOrderCancellationRestApi\Processor\Manager;

use FondOfImpala\Client\ErpOrderCancellationRestApi\ErpOrderCancellationRestApiClientInterface;
use FondOfImpala\Glue\ErpOrderCancellationRestApi\Processor\Builder\RestResponseBuilderInterface;
use FondOfImpala\Glue\ErpOrderCancellationRestApi\Processor\Mapper\ErpOrderCancellationMapperInterface;
use Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CancellationManager implements CancellationManagerInterface
{
    /**
     * @var \FondOfImpala\Client\ErpOrderCancellationRestApi\ErpOrderCancellationRestApiClientInterface
     */
    protected ErpOrderCancellationRestApiClientInterface $client;

    /**
     * @var \FondOfImpala\Glue\ErpOrderCancellationRestApi\Processor\Mapper\ErpOrderCancellationMapperInterface
     */
    protected ErpOrderCancellationMapperInterface $erpOrderCancellationMapper;

    /**
     * @var \FondOfImpala\Glue\ErpOrderCancellationRestApi\Processor\Builder\RestResponseBuilderInterface
     */
    protected RestResponseBuilderInterface $responseBuilder;

    /**
     * @param \FondOfImpala\Client\ErpOrderCancellationRestApi\ErpOrderCancellationRestApiClientInterface $client
     * @param \FondOfImpala\Glue\ErpOrderCancellationRestApi\Processor\Mapper\ErpOrderCancellationMapperInterface $erpOrderCancellationMapper
     * @param \FondOfImpala\Glue\ErpOrderCancellationRestApi\Processor\Builder\RestResponseBuilderInterface $responseBuilder
     */
    public function __construct(
        ErpOrderCancellationRestApiClientInterface $client,
        ErpOrderCancellationMapperInterface $erpOrderCancellationMapper,
        RestResponseBuilderInterface $responseBuilder
    ) {
        $this->client = $client;
        $this->erpOrderCancellationMapper = $erpOrderCancellationMapper;
        $this->responseBuilder = $responseBuilder;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function add(RestRequestInterface $restRequest): RestResponseInterface
    {
        $erpOrderCancellationRestResponseTransfer = $this->handleAdd($restRequest);

        if ($erpOrderCancellationRestResponseTransfer instanceof RestErrorMessageTransfer) {
            return $this->responseBuilder->buildErrorResponse($erpOrderCancellationRestResponseTransfer);
        }

        return $this->responseBuilder->buildErpOrderCancellationRestResponse($erpOrderCancellationRestResponseTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer|\Generated\Shared\Transfer\RestErrorMessageTransfer
     */
    protected function handleAdd(RestRequestInterface $restRequest): RestErpOrderCancellationResponseTransfer|RestErrorMessageTransfer
    {
        $attributes = $this->erpOrderCancellationMapper->createAttributesFromRequest($restRequest);
        $erpOrderCancellationRestRequestTransfer = $this->erpOrderCancellationMapper->createRequest($restRequest, $attributes);

        return $this->client->addErpOrderCancellation($erpOrderCancellationRestRequestTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function get(RestRequestInterface $restRequest): RestResponseInterface
    {
        $attributes = $this->erpOrderCancellationMapper->createAttributesFromRequest($restRequest);

        $erpOrderCancellationRestRequestTransfer = $this->erpOrderCancellationMapper->createRequest($restRequest, $attributes);
        $erpOrderCancellationRestResponseTransfer = $this->client->getErpOrderCancellation($erpOrderCancellationRestRequestTransfer);

        if ($erpOrderCancellationRestResponseTransfer instanceof RestErrorMessageTransfer) {
            return $this->responseBuilder->buildErrorResponse($erpOrderCancellationRestResponseTransfer);
        }

        return $this->responseBuilder->buildErpOrderCancellationCollectionRestResponse($erpOrderCancellationRestResponseTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function patch(RestRequestInterface $restRequest): RestResponseInterface
    {
        $attributes = $this->erpOrderCancellationMapper->createAttributesFromRequest($restRequest);

        $erpOrderCancellationRestRequestTransfer = $this->erpOrderCancellationMapper->createRequest($restRequest, $attributes);
        $erpOrderCancellationRestResponseTransfer = $this->client->patchErpOrderCancellation($erpOrderCancellationRestRequestTransfer);

        if ($erpOrderCancellationRestResponseTransfer instanceof RestErrorMessageTransfer) {
            return $this->responseBuilder->buildErrorResponse($erpOrderCancellationRestResponseTransfer);
        }

        return $this->responseBuilder->buildErpOrderCancellationRestResponse($erpOrderCancellationRestResponseTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function delete(RestRequestInterface $restRequest): RestResponseInterface
    {
        $attributes = $this->erpOrderCancellationMapper->createAttributesFromRequest($restRequest);

        $erpOrderCancellationRestRequestTransfer = $this->erpOrderCancellationMapper->createRequest($restRequest, $attributes);
        $erpOrderCancellationRestResponseTransfer = $this->client->deleteErpOrderCancellation($erpOrderCancellationRestRequestTransfer);

        if ($erpOrderCancellationRestResponseTransfer instanceof RestErrorMessageTransfer) {
            return $this->responseBuilder->buildErrorResponse($erpOrderCancellationRestResponseTransfer);
        }

        return $this->responseBuilder->buildErpOrderCancellationRestResponse($erpOrderCancellationRestResponseTransfer);
    }
}
