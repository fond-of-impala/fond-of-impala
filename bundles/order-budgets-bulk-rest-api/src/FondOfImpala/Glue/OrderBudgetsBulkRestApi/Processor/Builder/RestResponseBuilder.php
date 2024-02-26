<?php

namespace FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Builder;

use FondOfImpala\Glue\OrderBudgetsBulkRestApi\OrderBudgetsBulkRestApiConfig;
use Generated\Shared\Transfer\RestOrderBudgetsBulkResponseTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkTransfer;
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
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkResponseTransfer $restOrderBudgetsBulkResponseTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function buildRestResponseByRestOrderBudgetsBulkResponse(
        RestOrderBudgetsBulkResponseTransfer $restOrderBudgetsBulkResponseTransfer
    ): RestResponseInterface {
        if (!$restOrderBudgetsBulkResponseTransfer->getIsSuccessful()) {
            return $this->restResourceBuilder->createRestResponse()
                ->setStatus(Response::HTTP_BAD_REQUEST);
        }

        $restOrderBudgetsBulkTransfer = (new RestOrderBudgetsBulkTransfer())
            ->fromArray($restOrderBudgetsBulkResponseTransfer->toArray(), true);

        $restResource = $this->restResourceBuilder->createRestResource(
            OrderBudgetsBulkRestApiConfig::RESOURCE_ORDER_BUDGETS_BULK,
            null,
            $restOrderBudgetsBulkTransfer,
        );

        $restResource->setPayload($restOrderBudgetsBulkTransfer);

        return $this->restResourceBuilder->createRestResponse()
            ->setStatus(Response::HTTP_CREATED)
            ->addResource($restResource);
    }
}
