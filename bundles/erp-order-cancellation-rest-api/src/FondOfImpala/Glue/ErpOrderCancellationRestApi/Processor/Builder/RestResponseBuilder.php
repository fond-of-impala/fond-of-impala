<?php

namespace FondOfImpala\Glue\ErpOrderCancellationRestApi\Processor\Builder;

use FondOfImpala\Glue\ErpOrderCancellationRestApi\ErpOrderCancellationRestApiConfig;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationCollectionResponseTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class RestResponseBuilder implements RestResponseBuilderInterface
{
    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilder;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     */
    public function __construct(
        RestResourceBuilderInterface $restResourceBuilder
    ) {
        $this->restResourceBuilder = $restResourceBuilder;
    }

    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer $restErpOrderCancellationResponseTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function buildErpOrderCancellationRestResponse(
        RestErpOrderCancellationResponseTransfer $restErpOrderCancellationResponseTransfer
    ): RestResponseInterface {
        $restResponse = $this->restResourceBuilder->createRestResponse();

        $restResource = $this->restResourceBuilder->createRestResource(
            ErpOrderCancellationRestApiConfig::RESOURCE_ERP_ORDER_CANCELLATION_REST_API,
            $this->getUuidFromRestErpOrderCancellationResponse($restErpOrderCancellationResponseTransfer),
            $restErpOrderCancellationResponseTransfer,
        );

        return $restResponse->addResource($restResource);
    }

    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationCollectionResponseTransfer $restErpOrderCancellationCollectionResponseTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function buildErpOrderCancellationCollectionRestResponse(
        RestErpOrderCancellationCollectionResponseTransfer $restErpOrderCancellationCollectionResponseTransfer
    ): RestResponseInterface {
        $restResponse = $this->restResourceBuilder->createRestResponse();

        $restResource = $this->restResourceBuilder->createRestResource(
            ErpOrderCancellationRestApiConfig::RESOURCE_ERP_ORDER_CANCELLATION_REST_API,
            null,
            $restErpOrderCancellationCollectionResponseTransfer,
        );

        return $restResponse->addResource($restResource);
    }

    /**
     * @param \Generated\Shared\Transfer\RestErrorMessageTransfer|null $restErrorMessageTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function buildErrorResponse(?RestErrorMessageTransfer $restErrorMessageTransfer = null): RestResponseInterface
    {
        if ($restErrorMessageTransfer === null) {
            $restErrorMessageTransfer = (new RestErrorMessageTransfer())
                ->setCode((string)ErpOrderCancellationRestApiConfig::RESPONSE_CODE_USER_IS_NOT_ALLOWED_TO_ADD_ERP_ORDER_CANCELLATION)
                ->setStatus(Response::HTTP_FORBIDDEN)
                ->setDetail(ErpOrderCancellationRestApiConfig::ERROR_MESSAGE_USER_IS_NOT_ALLOWED_TO_ADD_ERP_ORDER_CANCELLATION);

            return $this->restResourceBuilder
                ->createRestResponse()
                ->addError($restErrorMessageTransfer);
        }

        return $this->restResourceBuilder
            ->createRestResponse()
            ->addError($restErrorMessageTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer $restErpOrderCancellationResponseTransfer
     *
     * @return string|null
     */
    protected function getUuidFromRestErpOrderCancellationResponse(
        RestErpOrderCancellationResponseTransfer $restErpOrderCancellationResponseTransfer
    ): ?string {
        $erpOrderCancellation = $restErpOrderCancellationResponseTransfer->getErpOrderCancellation();

        if ($erpOrderCancellation === null) {
            return null;
        }

        return $erpOrderCancellation->getUuid();
    }
}
