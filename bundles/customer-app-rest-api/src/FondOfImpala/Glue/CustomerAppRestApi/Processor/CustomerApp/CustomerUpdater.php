<?php

namespace FondOfImpala\Glue\CustomerAppRestApi\Processor\CustomerApp;

use Exception;
use FondOfImpala\Glue\CustomerAppRestApi\CustomerAppRestApiConfig;
use FondOfImpala\Glue\CustomerAppRestApi\Dependency\Client\CustomerAppRestApiToCustomerClientInterface;
use FondOfImpala\Glue\CustomerAppRestApi\Processor\Validation\RestApiErrorInterface;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\RestCustomerAppAttributesTransfer;
use Generated\Shared\Transfer\RestCustomerAppRequestAttributesTransfer;
use JsonException;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Throwable;

class CustomerUpdater implements CustomerUpdaterInterface
{
    protected CustomerAppRestApiToCustomerClientInterface $customerClient;

    protected CustomerAppMapperInterface $customerAppMapper;

    protected RestApiErrorInterface $restApiError;

    protected RestResourceBuilderInterface $restResourceBuilder;

    /**
     * @param \FondOfImpala\Glue\CustomerAppRestApi\Dependency\Client\CustomerAppRestApiToCustomerClientInterface $customerClient
     * @param \FondOfImpala\Glue\CustomerAppRestApi\Processor\CustomerApp\CustomerAppMapperInterface $customerAppMapper
     */
    public function __construct(
        CustomerAppRestApiToCustomerClientInterface $customerClient,
        CustomerAppMapperInterface                  $customerAppMapper,
        RestApiErrorInterface                       $restApiError,
        RestResourceBuilderInterface                $restResourceBuilder
    )
    {
        $this->customerClient = $customerClient;
        $this->customerAppMapper = $customerAppMapper;
        $this->restApiError = $restApiError;
        $this->restResourceBuilder = $restResourceBuilder;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestCustomerAppRequestAttributesTransfer $restCustomerAppRequestAttributesTransfer
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function updateCustomer(
        RestRequestInterface                     $restRequest,
        RestCustomerAppRequestAttributesTransfer $restCustomerAppRequestAttributesTransfer
    ): RestResponseInterface
    {
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
            $customer = $this->customerAppMapper->mapRestCustomerAppRequestAttributesTransferToCustomerTransfer($customer, $restCustomerAppRequestAttributesTransfer);
        } catch (JsonException $e) {
            return $this->restApiError->addCustomerAppDataInvalidError($restResponse);
        } catch (Throwable $e) {
            return $this->restApiError->addCustomerAppDataNotUpdatedError($restResponse);
        }

        $response = $this->customerClient->updateCustomer($customer);

        if (!$response->getIsSuccess()) {
            return $this->restApiError->addCustomerAppDataNotUpdatedError($restResponse);
        }

        return $this->addCustomerAppTransferToResponse(
            $response,
            $restResponse,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerResponseTransfer $responseTransfer
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function addCustomerAppTransferToResponse(
        CustomerResponseTransfer $responseTransfer,
        RestResponseInterface    $restResponse
    ): RestResponseInterface
    {
        $customer = $responseTransfer->getCustomerTransfer();
        $restCustomerAppAttributesTransfer = $this->customerAppMapper->mapCustomerTransferToRestCustomerAppResponseAttributesTransfer(
            $customer
        );

        $restResource = $this->restResourceBuilder->createRestResource(
            CustomerAppRestApiConfig::RESOURCE_CUSTOMER_APP,
            $customer->getCustomerReference(),
            $restCustomerAppAttributesTransfer,
        );

        return $restResponse->addResource($restResource);
    }
}
