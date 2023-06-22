<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Processor\ConditionalAvailabilityPageSearch\Reader;

use FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\ConditionalAvailabilityPageSearchRestApiConfig;
use FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Dependency\Client\ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityPageSearchClientInterface;
use FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Processor\ConditionalAvailabilityPageSearch\Mapper\ConditionalAvailabilityPageSearchMapperInterface;
use Generated\Shared\Transfer\RestConditionalAvailabilityPageSearchCollectionResponseTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\Page;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class ConditionalAvailabilityPageSearchReader implements ConditionalAvailabilityPageSearchReaderInterface
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

    /**
     * @var \FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Dependency\Client\ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityPageSearchClientInterface
     */
    protected $conditionalAvailabilityPageSearchClient;

    /**
     * @var \FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Processor\ConditionalAvailabilityPageSearch\Mapper\ConditionalAvailabilityPageSearchMapperInterface
     */
    protected $conditionalAvailabilityPeriodMapper;

    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilder;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Dependency\Client\ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityPageSearchClientInterface $conditionalAvailabilityPageSearchClient
     * @param \FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Processor\ConditionalAvailabilityPageSearch\Mapper\ConditionalAvailabilityPageSearchMapperInterface $conditionalAvailabilityPeriodMapper
     */
    public function __construct(
        RestResourceBuilderInterface $restResourceBuilder,
        ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityPageSearchClientInterface $conditionalAvailabilityPageSearchClient,
        ConditionalAvailabilityPageSearchMapperInterface $conditionalAvailabilityPeriodMapper
    ) {
        $this->conditionalAvailabilityPageSearchClient = $conditionalAvailabilityPageSearchClient;
        $this->conditionalAvailabilityPeriodMapper = $conditionalAvailabilityPeriodMapper;
        $this->restResourceBuilder = $restResourceBuilder;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function get(RestRequestInterface $restRequest): RestResponseInterface
    {
        $requestParameters = $this->getAllRequestParameters($restRequest);

        $searchString = $this->getRequestParameter(
            $restRequest,
            ConditionalAvailabilityPageSearchRestApiConfig::QUERY_STRING_PARAMETER,
        );

        $searchResult = $this->conditionalAvailabilityPageSearchClient->search($searchString, $requestParameters);

        $restConditionalAvailabilityPeriodCollectionResponseTransfer = $this->conditionalAvailabilityPeriodMapper
            ->mapSearchResultToRestConditionalAvailabilityPageSearchCollectionResponseTransfer($searchResult);

        return $this->buildCollectionResponse(
            $restRequest,
            $restConditionalAvailabilityPeriodCollectionResponseTransfer,
        );
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
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestConditionalAvailabilityPageSearchCollectionResponseTransfer $restConditionalAvailabilityPeriodCollectionResponseTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function buildCollectionResponse(
        RestRequestInterface $restRequest,
        RestConditionalAvailabilityPageSearchCollectionResponseTransfer $restConditionalAvailabilityPeriodCollectionResponseTransfer
    ): RestResponseInterface {
        $restResource = $this->restResourceBuilder->createRestResource(
            ConditionalAvailabilityPageSearchRestApiConfig::RESOURCE_CONDITIONAL_AVAILABILITY_PAGE_SEARCH,
            null,
            $restConditionalAvailabilityPeriodCollectionResponseTransfer,
        );

        $response = $this->restResourceBuilder->createRestResponse(
            $restConditionalAvailabilityPeriodCollectionResponseTransfer->getPagination()->getNumFound(),
        );

        if (!$restRequest->getPage()) {
            $restRequest->setPage(new Page(0, static::DEFAULT_ITEMS_PER_PAGE));
        }

        return $response->addResource($restResource);
    }
}
