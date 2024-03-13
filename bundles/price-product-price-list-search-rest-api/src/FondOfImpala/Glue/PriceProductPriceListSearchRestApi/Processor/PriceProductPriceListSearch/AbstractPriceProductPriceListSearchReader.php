<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\PriceProductPriceListSearch;

use FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Dependency\Client\PriceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientInterface;
use FondOfImpala\Glue\PriceProductPriceListSearchRestApi\PriceProductPriceListSearchRestApiConfig;
use FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\Mapper\PriceProductPriceListSearchResourceMapperInterface;
use FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\Reducer\PriceDataReducerPluginExecutorInterface;
use Generated\Shared\Transfer\RestPriceProductPriceListSearchAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

abstract class AbstractPriceProductPriceListSearchReader implements PriceProductPriceListSearchReaderInterface
{
    /**
     * @var int
     */
    protected const DEFAULT_ITEMS_PER_PAGE = 12;

    /**
     * @var string
     */
    protected const PARAMETER_NAME_PAGE = 'page';

    /**
     * @var string
     */
    protected const PARAMETER_NAME_ITEMS_PER_PAGE = 'ipp';

    protected PriceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientInterface $priceProductPriceListPageSearchClient;

    protected PriceProductPriceListSearchResourceMapperInterface $priceProductPriceListSearchResourceMapper;

    protected RestResourceBuilderInterface $restResourceBuilder;

    protected PriceDataReducerPluginExecutorInterface $reducerPluginExecutor;

    /**
     * @param \FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Dependency\Client\PriceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientInterface $priceProductPriceListPageSearchClient
     * @param \FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\Mapper\PriceProductPriceListSearchResourceMapperInterface $priceProductPriceListSearchResourceMapper
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\Reducer\PriceDataReducerPluginExecutorInterface $reducerPluginExecutor
     */
    public function __construct(
        PriceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientInterface $priceProductPriceListPageSearchClient,
        PriceProductPriceListSearchResourceMapperInterface $priceProductPriceListSearchResourceMapper,
        RestResourceBuilderInterface $restResourceBuilder,
        PriceDataReducerPluginExecutorInterface $reducerPluginExecutor
    ) {
        $this->priceProductPriceListPageSearchClient = $priceProductPriceListPageSearchClient;
        $this->priceProductPriceListSearchResourceMapper = $priceProductPriceListSearchResourceMapper;
        $this->restResourceBuilder = $restResourceBuilder;
        $this->reducerPluginExecutor = $reducerPluginExecutor;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function search(RestRequestInterface $restRequest): RestResponseInterface
    {
        $searchString = $this->getRequestParameter(
            $restRequest,
            PriceProductPriceListSearchRestApiConfig::QUERY_STRING_PARAMETER,
        );

        $requestParameters = $this->getAllRequestParameters($restRequest);

        $searchResult = $this->doSearch($searchString, $requestParameters);

        $restSearchAttributesTransfer = $this->priceProductPriceListSearchResourceMapper
            ->mapRestSearchResponseToRestAttributesTransfer($searchResult);

        return $this->buildRestResponse($restRequest, $restSearchAttributesTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param string $parameterName
     *
     * @return string
     */
    protected function getRequestParameter(RestRequestInterface $restRequest, string $parameterName): string
    {
        return $restRequest->getHttpRequest()->query->get($parameterName, '');
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return array
     */
    protected function getAllRequestParameters(RestRequestInterface $restRequest): array
    {
        $params = $restRequest->getHttpRequest()->query->all();
        if ($restRequest->getPage()) {
            $params[static::PARAMETER_NAME_ITEMS_PER_PAGE] = $restRequest->getPage()->getLimit();
            $params[static::PARAMETER_NAME_PAGE] = ($restRequest->getPage()->getOffset() / $restRequest->getPage()->getLimit()) + 1;
        }

        return $params;
    }

    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return array
     */
    abstract protected function doSearch(string $searchString, array $requestParameters): array;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestPriceProductPriceListSearchAttributesTransfer $restPriceProductPriceListSearchAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    abstract protected function buildRestResponse(
        RestRequestInterface $restRequest,
        RestPriceProductPriceListSearchAttributesTransfer $restPriceProductPriceListSearchAttributesTransfer
    ): RestResponseInterface;
}
