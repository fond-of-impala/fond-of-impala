<?php

namespace FondOfImpala\Glue\CustomerAppRestApi\Processor\Validation;

use FondOfImpala\Glue\CustomerAppRestApi\CustomerAppRestApiConfig;
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
    public function addCustomerNotMatchError(RestResponseInterface $restResponse): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode(CustomerAppRestApiConfig::RESPONSE_CODE_CUSTOMER_NOT_MATCH)
            ->setStatus(Response::HTTP_NOT_FOUND)
            ->setDetail(CustomerAppRestApiConfig::RESPONSE_DETAILS_CUSTOMER_NOT_MATCH);

        return $restResponse->addError($restErrorMessageTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function addCustomerReferenceMissingError(RestResponseInterface $restResponse): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode(CustomerAppRestApiConfig::RESPONSE_CODE_REFERENCE_MISSING)
            ->setStatus(Response::HTTP_BAD_REQUEST)
            ->setDetail(CustomerAppRestApiConfig::RESPONSE_DETAILS_REFERENCE_MISSING);

        return $restResponse->addError($restErrorMessageTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function addCustomerAppDataNotUpdatedError(RestResponseInterface $restResponse): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode(CustomerAppRestApiConfig::RESPONSE_CODE_APP_DATA_NOT_UPDATED)
            ->setStatus(Response::HTTP_BAD_REQUEST)
            ->setDetail(CustomerAppRestApiConfig::RESPONSE_DETAILS_APP_DATA_NOT_UPDATED);

        return $restResponse->addError($restErrorMessageTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function addCustomerAppDataInvalidError(RestResponseInterface $restResponse): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode(CustomerAppRestApiConfig::RESPONSE_CODE_APP_DATA_INVALID)
            ->setStatus(Response::HTTP_BAD_REQUEST)
            ->setDetail(CustomerAppRestApiConfig::RESPONSE_DETAILS_APP_DATA_INVALID);

        return $restResponse->addError($restErrorMessageTransfer);
    }
}
