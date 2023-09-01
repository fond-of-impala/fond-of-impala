<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\PriceProductPriceListSearch;

use Codeception\Test\Unit;
use FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Dependency\Client\PriceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientInterface;
use FondOfImpala\Glue\PriceProductPriceListSearchRestApi\PriceProductPriceListSearchRestApiConfig;
use FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\Mapper\PriceProductPriceListSearchResourceMapperInterface;
use Generated\Shared\Transfer\RestPriceProductPriceListSearchAttributesTransfer;
use Generated\Shared\Transfer\RestPriceProductPriceListSearchPaginationTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\PageInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class PriceProductAbstractPriceListSearchReaderTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\PriceProductPriceListSearch\PriceProductAbstractPriceListSearchReader
     */
    protected PriceProductAbstractPriceListSearchReader $priceProductAbstractPriceListSearchReader;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Dependency\Client\PriceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientInterface
     */
    protected MockObject|PriceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientInterface $priceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\Mapper\PriceProductPriceListSearchResourceMapperInterface
     */
    protected MockObject|PriceProductPriceListSearchResourceMapperInterface $priceProductPriceListSearchResourceMapperInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected MockObject|RestResourceBuilderInterface $restResourceBuilderInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected MockObject|RestRequestInterface $restRequestInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Symfony\Component\HttpFoundation\Request
     */
    protected MockObject|Request $requestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Symfony\Component\HttpFoundation\ParameterBag
     */
    protected MockObject|ParameterBag $parameterBag;

    /**
     * @var string
     */
    protected string $requestParameter;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\PageInterface
     */
    protected MockObject|PageInterface $pageInterfaceMock;

    /**
     * @var int
     */
    protected int $limit;

    /**
     * @var int
     */
    protected int $offset;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestPriceProductPriceListSearchAttributesTransfer
     */
    protected MockObject|RestPriceProductPriceListSearchAttributesTransfer $restPriceProductPriceListSearchAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected MockObject|RestResourceInterface $restResourceInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestPriceProductPriceListSearchPaginationTransfer
     */
    protected MockObject|RestPriceProductPriceListSearchPaginationTransfer $restPriceProductPriceListSearchPaginationTransferMock;

    /**
     * @var int
     */
    protected int $numFound;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected MockObject|RestResponseInterface $restResponseInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->priceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientInterfaceMock = $this->getMockBuilder(PriceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListSearchResourceMapperInterfaceMock = $this->getMockBuilder(PriceProductPriceListSearchResourceMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceBuilderInterfaceMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestInterfaceMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->requestMock = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->parameterBag = $this->getMockBuilder(ParameterBag::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->requestMock->query = $this->parameterBag;

        $this->requestParameter = '';

        $this->pageInterfaceMock = $this->getMockBuilder(PageInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->limit = 1;

        $this->offset = 1;

        $this->restPriceProductPriceListSearchAttributesTransferMock = $this->getMockBuilder(RestPriceProductPriceListSearchAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceInterfaceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restPriceProductPriceListSearchPaginationTransferMock = $this->getMockBuilder(RestPriceProductPriceListSearchPaginationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->numFound = 2;

        $this->restResponseInterfaceMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductAbstractPriceListSearchReader = new PriceProductAbstractPriceListSearchReader(
            $this->priceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientInterfaceMock,
            $this->priceProductPriceListSearchResourceMapperInterfaceMock,
            $this->restResourceBuilderInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testSearch(): void
    {
        $this->restRequestInterfaceMock->expects(static::atLeastOnce())
            ->method('getHttpRequest')
            ->willReturn($this->requestMock);

        $this->parameterBag->expects(static::atLeastOnce())
            ->method('get')
            ->with(PriceProductPriceListSearchRestApiConfig::QUERY_STRING_PARAMETER, '')
            ->willReturn($this->requestParameter);

        $this->parameterBag->expects(static::atLeastOnce())
            ->method('all')
            ->willReturn([]);

        $this->restRequestInterfaceMock->expects(static::atLeastOnce())
            ->method('getPage')
            ->willReturn($this->pageInterfaceMock);

        $this->pageInterfaceMock->expects(static::atLeastOnce())
            ->method('getLimit')
            ->willReturn($this->limit);

        $this->pageInterfaceMock->expects(static::atLeastOnce())
            ->method('getOffset')
            ->willReturn($this->offset);

        $this->priceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientInterfaceMock->expects(static::atLeastOnce())
            ->method('searchAbstract')
            ->willReturn([]);

        $this->priceProductPriceListSearchResourceMapperInterfaceMock->expects(static::atLeastOnce())
            ->method('mapRestSearchResponseToRestAttributesTransfer')
            ->willReturn($this->restPriceProductPriceListSearchAttributesTransferMock);

        $this->restResourceBuilderInterfaceMock->expects(static::atLeastOnce())
            ->method('createRestResource')
            ->with(
                PriceProductPriceListSearchRestApiConfig::RESOURCE_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_SEARCH,
                null,
                $this->restPriceProductPriceListSearchAttributesTransferMock,
            )->willReturn($this->restResourceInterfaceMock);

        $this->restPriceProductPriceListSearchAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getPagination')
            ->willReturn($this->restPriceProductPriceListSearchPaginationTransferMock);

        $this->restPriceProductPriceListSearchPaginationTransferMock->expects(static::atLeastOnce())
            ->method('getNumFound')
            ->willReturn($this->numFound);

        $this->restResourceBuilderInterfaceMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->with($this->numFound)
            ->willReturn($this->restResponseInterfaceMock);

        $this->restResponseInterfaceMock->expects(static::atLeastOnce())
            ->method('addResource')
            ->with($this->restResourceInterfaceMock)
            ->willReturnSelf();

        static::assertInstanceOf(
            RestResponseInterface::class,
            $this->priceProductAbstractPriceListSearchReader->search(
                $this->restRequestInterfaceMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testSearchPageNull(): void
    {
        $this->restRequestInterfaceMock->expects(static::atLeastOnce())
            ->method('getHttpRequest')
            ->willReturn($this->requestMock);

        $this->parameterBag->expects(static::atLeastOnce())
            ->method('get')
            ->with(PriceProductPriceListSearchRestApiConfig::QUERY_STRING_PARAMETER, '')
            ->willReturn($this->requestParameter);

        $this->parameterBag->expects(static::atLeastOnce())
            ->method('all')
            ->willReturn([]);

        $this->restRequestInterfaceMock->expects(static::atLeastOnce())
            ->method('getPage')
            ->willReturn(null);

        $this->priceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientInterfaceMock->expects(static::atLeastOnce())
            ->method('searchAbstract')
            ->willReturn([]);

        $this->priceProductPriceListSearchResourceMapperInterfaceMock->expects(static::atLeastOnce())
            ->method('mapRestSearchResponseToRestAttributesTransfer')
            ->willReturn($this->restPriceProductPriceListSearchAttributesTransferMock);

        $this->restResourceBuilderInterfaceMock->expects(static::atLeastOnce())
            ->method('createRestResource')
            ->with(
                PriceProductPriceListSearchRestApiConfig::RESOURCE_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_SEARCH,
                null,
                $this->restPriceProductPriceListSearchAttributesTransferMock,
            )->willReturn($this->restResourceInterfaceMock);

        $this->restPriceProductPriceListSearchAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getPagination')
            ->willReturn($this->restPriceProductPriceListSearchPaginationTransferMock);

        $this->restPriceProductPriceListSearchPaginationTransferMock->expects(static::atLeastOnce())
            ->method('getNumFound')
            ->willReturn($this->numFound);

        $this->restResourceBuilderInterfaceMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->with($this->numFound)
            ->willReturn($this->restResponseInterfaceMock);

        $this->restResponseInterfaceMock->expects(static::atLeastOnce())
            ->method('addResource')
            ->with($this->restResourceInterfaceMock)
            ->willReturnSelf();

        static::assertInstanceOf(
            RestResponseInterface::class,
            $this->priceProductAbstractPriceListSearchReader->search(
                $this->restRequestInterfaceMock,
            ),
        );
    }
}
