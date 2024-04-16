<?php

namespace FondOfImpala\Glue\WebUiSettings\Processor\Validation;

use FondOfImpala\Glue\WebUiSettings\WebUiSettingsConfig;
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
            ->setCode(WebUiSettingsConfig::RESPONSE_CODE_CUSTOMER_NOT_MATCH)
            ->setStatus(Response::HTTP_NOT_FOUND)
            ->setDetail(WebUiSettingsConfig::RESPONSE_DETAILS_CUSTOMER_NOT_MATCH);

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
            ->setCode(WebUiSettingsConfig::RESPONSE_CODE_REFERENCE_MISSING)
            ->setStatus(Response::HTTP_BAD_REQUEST)
            ->setDetail(WebUiSettingsConfig::RESPONSE_DETAILS_REFERENCE_MISSING);

        return $restResponse->addError($restErrorMessageTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function addWebUiSettingsDataNotUpdatedError(RestResponseInterface $restResponse): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode(WebUiSettingsConfig::RESPONSE_CODE_APP_DATA_NOT_UPDATED)
            ->setStatus(Response::HTTP_BAD_REQUEST)
            ->setDetail(WebUiSettingsConfig::RESPONSE_DETAILS_APP_DATA_NOT_UPDATED);

        return $restResponse->addError($restErrorMessageTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function addWebUiSettingsDataInvalidError(RestResponseInterface $restResponse): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode(WebUiSettingsConfig::RESPONSE_CODE_APP_DATA_INVALID)
            ->setStatus(Response::HTTP_BAD_REQUEST)
            ->setDetail(WebUiSettingsConfig::RESPONSE_DETAILS_APP_DATA_INVALID);

        return $restResponse->addError($restErrorMessageTransfer);
    }
}
