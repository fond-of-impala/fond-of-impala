<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Builder;

use FondOfImpala\Glue\ProductListsBulkRestApi\ProductListsBulkRestApiConfig;
use Generated\Shared\Transfer\RestProductListsBulkResponseTransfer;
use Generated\Shared\Transfer\RestProductListsBulkTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class RestResponseBuilder implements RestResponseBuilderInterface
{
    protected RestResourceBuilderInterface $restResourceBuilder;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     */
    public function __construct(
        RestResourceBuilderInterface $restResourceBuilder
    ) {
        $this->restResourceBuilder = $restResourceBuilder;
    }

    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkResponseTransfer $restProductListsBulkResponseTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function buildByRestProductListsBulkResponse(
        RestProductListsBulkResponseTransfer $restProductListsBulkResponseTransfer
    ): RestResponseInterface {
        if (!$restProductListsBulkResponseTransfer->getIsSuccessful()) {
            return $this->restResourceBuilder->createRestResponse()
                ->setStatus(Response::HTTP_BAD_REQUEST);
        }

        $restProductListsBulkTransfer = (new RestProductListsBulkTransfer())
            ->fromArray($restProductListsBulkResponseTransfer->toArray(), true);

        $restResource = $this->restResourceBuilder->createRestResource(
            ProductListsBulkRestApiConfig::RESOURCE_PRODUCT_LISTS_BULK,
            null,
            $restProductListsBulkTransfer,
        );

        $restResource->setPayload($restProductListsBulkTransfer);

        return $this->restResourceBuilder->createRestResponse()
            ->setStatus(Response::HTTP_CREATED)
            ->addResource($restResource);
    }
}
