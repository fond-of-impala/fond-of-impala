<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Processor\ConditionalAvailabilityPageSearch\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\ConditionalAvailabilityPageSearchRestApiConfig;
use FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Dependency\Client\ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityPageSearchClientInterface;
use FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Processor\ConditionalAvailabilityPageSearch\Mapper\ConditionalAvailabilityPageSearchMapperInterface;
use Generated\Shared\Transfer\RestConditionalAvailabilityPageSearchCollectionResponseTransfer;
use Generated\Shared\Transfer\RestConditionalAvailabilityPageSearchPaginationTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\PageInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;

class ConditionalAvailabilityPageSearchReaderTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Processor\ConditionalAvailabilityPageSearch\Reader\ConditionalAvailabilityPageSearchReader
     */
    protected ConditionalAvailabilityPageSearchReader $reader;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected MockObject|RestResourceBuilderInterface $restResourceBuilderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Dependency\Client\ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityPageSearchClientInterface
     */
    protected MockObject|ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityPageSearchClientInterface $conditionalAvailabilityPageSearchClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Processor\ConditionalAvailabilityPageSearch\Mapper\ConditionalAvailabilityPageSearchMapperInterface
     */
    protected MockObject|ConditionalAvailabilityPageSearchMapperInterface $conditionalAvailabilityPageSearchMapperMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected MockObject|RestRequestInterface $restRequestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Symfony\Component\HttpFoundation\Request
     */
    protected MockObject|Request $requestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Symfony\Component\HttpFoundation\ParameterBag
     */
    protected MockObject|ParameterBag $parameterBagMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestConditionalAvailabilityPageSearchCollectionResponseTransfer
     */
    protected MockObject|RestConditionalAvailabilityPageSearchCollectionResponseTransfer $restConditionalAvailabilityPageSearchCollectionResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected MockObject|RestResourceInterface $restResourceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestConditionalAvailabilityPageSearchPaginationTransfer
     */
    protected MockObject|RestConditionalAvailabilityPageSearchPaginationTransfer $restConditionalAvailabilityPageSearchPaginationTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected MockObject|RestResponseInterface $restResponseMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\PageInterface
     */
    protected $pageMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restResourceBuilderMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPageSearchClientMock = $this
            ->getMockBuilder(ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityPageSearchClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPageSearchMapperMock = $this
            ->getMockBuilder(ConditionalAvailabilityPageSearchMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->requestMock = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restConditionalAvailabilityPageSearchCollectionResponseTransferMock = $this->getMockBuilder(RestConditionalAvailabilityPageSearchCollectionResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restConditionalAvailabilityPageSearchPaginationTransferMock = $this->getMockBuilder(RestConditionalAvailabilityPageSearchPaginationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->pageMock = $this->getMockBuilder(PageInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->reader = new ConditionalAvailabilityPageSearchReader(
            $this->restResourceBuilderMock,
            $this->conditionalAvailabilityPageSearchClientMock,
            $this->conditionalAvailabilityPageSearchMapperMock,
        );
    }

    /**
     * @return void
     */
    public function testGet(): void
    {
        $numFound = 1;
        $searchResult = [];
        $this->requestMock->query = new InputBag();

        $this->restRequestMock->expects($this->atLeastOnce())
            ->method('getHttpRequest')
            ->willReturn($this->requestMock);

        $this->restRequestMock->expects($this->atLeastOnce())
            ->method('getPage')
            ->willReturn($this->pageMock);

        $this->pageMock->expects($this->atLeastOnce())
            ->method('getLimit')
            ->willReturn(12);

        $this->pageMock->expects($this->atLeastOnce())
            ->method('getOffset')
            ->willReturn(12);

        $this->conditionalAvailabilityPageSearchClientMock->expects($this->atLeastOnce())
            ->method('search')
            ->willReturn($searchResult);

        $this->conditionalAvailabilityPageSearchMapperMock->expects($this->atLeastOnce())
            ->method('mapSearchResultToRestConditionalAvailabilityPageSearchCollectionResponseTransfer')
            ->with($searchResult)
            ->willReturn($this->restConditionalAvailabilityPageSearchCollectionResponseTransferMock);

        $this->restResourceBuilderMock->expects($this->atLeastOnce())
            ->method('createRestResource')
            ->with(
                ConditionalAvailabilityPageSearchRestApiConfig::RESOURCE_CONDITIONAL_AVAILABILITY_PAGE_SEARCH,
                null,
                $this->restConditionalAvailabilityPageSearchCollectionResponseTransferMock,
            )->willReturn($this->restResourceMock);

        $this->restConditionalAvailabilityPageSearchCollectionResponseTransferMock->expects($this->atLeastOnce())
            ->method('getPagination')
            ->willReturn($this->restConditionalAvailabilityPageSearchPaginationTransferMock);

        $this->restConditionalAvailabilityPageSearchPaginationTransferMock->expects($this->atLeastOnce())
            ->method('getNumFound')
            ->willReturn($numFound);

        $this->restResourceBuilderMock->expects($this->atLeastOnce())
            ->method('createRestResponse')
            ->with($numFound)
            ->willReturn($this->restResponseMock);

        $this->restRequestMock->expects($this->never())
            ->method('setPage')
            ->willReturnSelf();

        $this->restResponseMock->expects($this->atLeastOnce())
            ->method('addResource')
            ->with($this->restResourceMock)
            ->willReturnSelf();

        static::assertEquals(
            $this->restResponseMock,
            $this->reader->get(
                $this->restRequestMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetWithoutPageParams(): void
    {
        $numFound = 1;
        $searchResult = [];
        $this->requestMock->query = new InputBag();

        $this->restRequestMock->expects($this->atLeastOnce())
            ->method('getHttpRequest')
            ->willReturn($this->requestMock);

        $this->restRequestMock->expects($this->atLeastOnce())
            ->method('getPage')
            ->willReturn(null);

        $this->pageMock->expects($this->never())
            ->method('getLimit');

        $this->pageMock->expects($this->never())
            ->method('getOffset');

        $this->conditionalAvailabilityPageSearchClientMock->expects($this->atLeastOnce())
            ->method('search')
            ->willReturn($searchResult);

        $this->conditionalAvailabilityPageSearchMapperMock->expects($this->atLeastOnce())
            ->method('mapSearchResultToRestConditionalAvailabilityPageSearchCollectionResponseTransfer')
            ->with($searchResult)
            ->willReturn($this->restConditionalAvailabilityPageSearchCollectionResponseTransferMock);

        $this->restResourceBuilderMock->expects($this->atLeastOnce())
            ->method('createRestResource')
            ->with(
                ConditionalAvailabilityPageSearchRestApiConfig::RESOURCE_CONDITIONAL_AVAILABILITY_PAGE_SEARCH,
                null,
                $this->restConditionalAvailabilityPageSearchCollectionResponseTransferMock,
            )->willReturn($this->restResourceMock);

        $this->restConditionalAvailabilityPageSearchCollectionResponseTransferMock->expects($this->atLeastOnce())
            ->method('getPagination')
            ->willReturn($this->restConditionalAvailabilityPageSearchPaginationTransferMock);

        $this->restConditionalAvailabilityPageSearchPaginationTransferMock->expects($this->atLeastOnce())
            ->method('getNumFound')
            ->willReturn($numFound);

        $this->restResourceBuilderMock->expects($this->atLeastOnce())
            ->method('createRestResponse')
            ->with($numFound)
            ->willReturn($this->restResponseMock);

        $this->restRequestMock->expects($this->atLeastOnce())
            ->method('setPage')
            ->willReturnSelf();

        $this->restResponseMock->expects($this->atLeastOnce())
            ->method('addResource')
            ->with($this->restResourceMock)
            ->willReturnSelf();

        static::assertEquals(
            $this->restResponseMock,
            $this->reader->get(
                $this->restRequestMock,
            ),
        );
    }
}
