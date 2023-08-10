<?php

namespace FondOfImpala\Glue\PriceListsRestApi\Processor\Validation;

use FondOfImpala\Glue\PriceListsRestApi\PriceListsRestApiConfig;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class RestApiError implements RestApiErrorInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function addPriceListNotFoundError(RestResponseInterface $restResponse): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode(PriceListsRestApiConfig::RESPONSE_CODE_PRICE_LIST_NOT_FOUND)
            ->setStatus(Response::HTTP_NOT_FOUND)
            ->setDetail(PriceListsRestApiConfig::RESPONSE_DETAILS_PRICE_LIST_NOT_FOUND);

        return $restResponse->addError($restErrorMessageTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function addPriceListIdMissingError(RestResponseInterface $restResponse): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode(PriceListsRestApiConfig::RESPONSE_CODE_UUID_MISSING)
            ->setStatus(Response::HTTP_BAD_REQUEST)
            ->setDetail(PriceListsRestApiConfig::RESPONSE_DETAILS_UUID_MISSING);

        return $restResponse->addError($restErrorMessageTransfer);
    }
}
