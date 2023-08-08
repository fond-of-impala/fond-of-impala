<?php

namespace FondOfImpala\Glue\PriceListsRestApi\Processor\PriceList;

use ArrayObject;
use FondOfImpala\Glue\PriceListsRestApi\Dependency\Client\PriceListsRestApiToPriceListClientInterface;
use FondOfImpala\Glue\PriceListsRestApi\PriceListsRestApiConfig;
use FondOfImpala\Glue\PriceListsRestApi\Processor\Validation\RestApiErrorInterface;
use Generated\Shared\Transfer\PriceListCollectionTransfer;
use Generated\Shared\Transfer\PriceListListTransfer;
use Generated\Shared\Transfer\PriceListTransfer;
use Generated\Shared\Transfer\RestPriceListAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class PriceListReader implements PriceListReaderInterface
{
    protected RestResourceBuilderInterface $restResourceBuilder;

    protected RestApiErrorInterface $restApiError;

    protected PriceListMapperInterface $priceListMapper;

    protected PriceListsRestApiToPriceListClientInterface $priceListClient;

    /**
     * @var array<\FondOfOryx\Glue\PriceListsRestApiExtension\Dependency\Plugin\FilterFieldsExpanderPluginInterface>
     */
    protected array $filterFieldsExpanderPlugins;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \FondOfImpala\Glue\PriceListsRestApi\Processor\Validation\RestApiErrorInterface $restApiError
     * @param \FondOfImpala\Glue\PriceListsRestApi\Dependency\Client\PriceListsRestApiToPriceListClientInterface $priceListClient
     * @param \FondOfImpala\Glue\PriceListsRestApi\Processor\PriceList\PriceListMapperInterface $priceListMapper
     * @param array<\FondOfOryx\Glue\PriceListsRestApiExtension\Dependency\Plugin\FilterFieldsExpanderPluginInterface> $filterFieldsExpanderPlugins
     */
    public function __construct(
        RestResourceBuilderInterface $restResourceBuilder,
        RestApiErrorInterface $restApiError,
        PriceListsRestApiToPriceListClientInterface $priceListClient,
        PriceListMapperInterface $priceListMapper,
        array $filterFieldsExpanderPlugins
    ) {
        $this->restResourceBuilder = $restResourceBuilder;
        $this->restApiError = $restApiError;
        $this->priceListClient = $priceListClient;
        $this->priceListMapper = $priceListMapper;
        $this->filterFieldsExpanderPlugins = $filterFieldsExpanderPlugins;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function getAllPriceLists(RestRequestInterface $restRequest): RestResponseInterface
    {
        $filterFieldTransfers = new ArrayObject();

        foreach ($this->filterFieldsExpanderPlugins as $filterFieldsExpanderPlugin) {
            $filterFieldTransfers = $filterFieldsExpanderPlugin->expand($restRequest, $filterFieldTransfers);
        }

        $priceListListTransfer = (new PriceListListTransfer())
            ->setFilterFields($filterFieldTransfers);

        $priceListListTransfer = $this->priceListClient->findPriceLists($priceListListTransfer);

        $priceListCollectionTransfer = (new PriceListCollectionTransfer())
            ->setPriceLists($priceListListTransfer->getPriceLists());

        return $this->addPriceListCollectionTransferToResponse(
            $priceListCollectionTransfer,
            $this->restResourceBuilder->createRestResponse(),
        );
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function getPriceListByUuid(RestRequestInterface $restRequest): RestResponseInterface
    {
        $restResponse = $this->restResourceBuilder->createRestResponse();
        $uuid = $restRequest->getResource()->getId();

        if ($uuid === null) {
            return $this->restApiError->addPriceListIdMissingError($restResponse);
        }

        $filterFieldTransfers = new ArrayObject();

        foreach ($this->filterFieldsExpanderPlugins as $filterFieldsExpanderPlugin) {
            $filterFieldTransfers = $filterFieldsExpanderPlugin->expand($restRequest, $filterFieldTransfers);
        }

        $priceListListTransfer = (new PriceListListTransfer())
            ->setFilterFields($filterFieldTransfers);

        $priceListListTransfer = $this->priceListClient->findPriceLists($priceListListTransfer);

        $priceListTransfers = $priceListListTransfer->getPriceLists();

        if ($priceListTransfers->count() !== 1 || $priceListTransfers->offsetGet(0)->getUuid() !== $uuid) {
            return $this->restApiError->addPriceListNotFoundError($restResponse);
        }

        return $this->addPriceListTransferToResponse(
            $priceListTransfers->offsetGet(0),
            $restResponse,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\PriceListCollectionTransfer $priceListCollectionTransfer
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function addPriceListCollectionTransferToResponse(
        PriceListCollectionTransfer $priceListCollectionTransfer,
        RestResponseInterface $restResponse
    ): RestResponseInterface {
        foreach ($priceListCollectionTransfer->getPriceLists() as $priceListTransfer) {
            $this->addPriceListTransferToResponse($priceListTransfer, $restResponse);
        }

        return $restResponse;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function addPriceListTransferToResponse(
        PriceListTransfer $priceListTransfer,
        RestResponseInterface $restResponse
    ): RestResponseInterface {
        $restPriceListAttributesTransfer = $this->priceListMapper->mapPriceListTransferToRestPriceListAttributesTransfer(
            $priceListTransfer,
            new RestPriceListAttributesTransfer(),
        );

        $restResource = $this->restResourceBuilder->createRestResource(
            PriceListsRestApiConfig::RESOURCE_PRICE_LISTS,
            $priceListTransfer->getUuid(),
            $restPriceListAttributesTransfer,
        );

        return $restResponse->addResource($restResource);
    }
}
