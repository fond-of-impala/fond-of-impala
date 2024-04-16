<?php

namespace FondOfImpala\Glue\WebUiSettings\Processor\WebUiSettings;

use FondOfImpala\Glue\WebUiSettings\Dependency\Client\WebUiSettingsToCustomerClientInterface;
use FondOfImpala\Glue\WebUiSettings\Processor\Validation\RestApiErrorInterface;
use FondOfImpala\Glue\WebUiSettings\WebUiSettingsConfig;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\RestWebUiSettingsRequestAttributesTransfer;
use JsonException;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Throwable;

class CustomerUpdater implements CustomerUpdaterInterface
{
    protected WebUiSettingsToCustomerClientInterface $customerClient;

    protected WebUiSettingsMapperInterface $customerAppMapper;

    protected RestApiErrorInterface $restApiError;

    protected RestResourceBuilderInterface $restResourceBuilder;

    /**
     * @param \FondOfImpala\Glue\WebUiSettings\Dependency\Client\WebUiSettingsToCustomerClientInterface $customerClient
     * @param \FondOfImpala\Glue\WebUiSettings\Processor\WebUiSettings\WebUiSettingsMapperInterface $customerAppMapper
     * @param \FondOfImpala\Glue\WebUiSettings\Processor\Validation\RestApiErrorInterface $restApiError
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     */
    public function __construct(
        WebUiSettingsToCustomerClientInterface $customerClient,
        WebUiSettingsMapperInterface $customerAppMapper,
        RestApiErrorInterface $restApiError,
        RestResourceBuilderInterface $restResourceBuilder
    ) {
        $this->customerClient = $customerClient;
        $this->customerAppMapper = $customerAppMapper;
        $this->restApiError = $restApiError;
        $this->restResourceBuilder = $restResourceBuilder;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestWebUiSettingsRequestAttributesTransfer $restWebUiSettingsRequestAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function updateCustomer(
        RestRequestInterface $restRequest,
        RestWebUiSettingsRequestAttributesTransfer $restWebUiSettingsRequestAttributesTransfer
    ): RestResponseInterface {
        $restResponse = $this->restResourceBuilder->createRestResponse();
        $customerReference = $restRequest->getResource()->getId();

        if ($customerReference === null) {
            return $this->restApiError->addCustomerReferenceMissingError($restResponse);
        }

        $customer = $this->customerClient->getCustomer();

        if ($customerReference !== $customer->getCustomerReference()) {
            return $this->restApiError->addCustomerNotMatchError($restResponse);
        }

        try {
            $customer = $this->customerAppMapper->mapRestWebUiSettingsRequestAttributesTransferToCustomerTransfer($customer, $restWebUiSettingsRequestAttributesTransfer);
        } catch (JsonException $e) {
            return $this->restApiError->addWebUiSettingsDataInvalidError($restResponse);
        } catch (Throwable $e) {
            return $this->restApiError->addWebUiSettingsDataNotUpdatedError($restResponse);
        }

        $response = $this->customerClient->updateCustomer($customer);

        if (!$response->getIsSuccess()) {
            return $this->restApiError->addWebUiSettingsDataNotUpdatedError($restResponse);
        }

        return $this->addWebUiSettingsTransferToResponse(
            $response,
            $restResponse,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerResponseTransfer $responseTransfer
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function addWebUiSettingsTransferToResponse(
        CustomerResponseTransfer $responseTransfer,
        RestResponseInterface $restResponse
    ): RestResponseInterface {
        $customer = $responseTransfer->getCustomerTransfer();
        $restWebUiSettingsAttributesTransfer = $this->customerAppMapper->mapCustomerTransferToRestWebUiSettingsResponseAttributesTransfer(
            $customer,
        );

        $restResource = $this->restResourceBuilder->createRestResource(
            WebUiSettingsConfig::RESOURCE_WEB_UI_SETTINGS,
            $customer->getCustomerReference(),
            $restWebUiSettingsAttributesTransfer,
        );

        return $restResponse->addResource($restResource);
    }
}
