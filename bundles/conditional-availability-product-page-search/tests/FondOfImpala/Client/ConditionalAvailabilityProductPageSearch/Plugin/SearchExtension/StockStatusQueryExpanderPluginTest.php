<?php

namespace FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\Plugin\SearchExtension;

use Codeception\Test\Unit;
use Elastica\Query;
use Elastica\Query\BoolQuery;
use Elastica\Query\MatchQuery;
use Elastica\Query\Term;
use FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\ConditionalAvailabilityProductPageSearchFactory;
use FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\Dependency\Client\ConditionalAvailabilityProductPageSearchToCustomerClientInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\SearchElasticsearch\Query\QueryBuilderInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

class StockStatusQueryExpanderPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Elastica\Query\BoolQuery
     */
    protected MockObject|BoolQuery $boolQueryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\Dependency\Client\ConditionalAvailabilityProductPageSearchToCustomerClientInterface
     */
    protected MockObject|ConditionalAvailabilityProductPageSearchToCustomerClientInterface $customerClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected MockObject|CustomerTransfer $customerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\ConditionalAvailabilityProductPageSearchFactory
     */
    protected MockObject|ConditionalAvailabilityProductPageSearchFactory $factoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Elastica\Query\MatchQuery
     */
    protected MockObject|MatchQuery $matchQueryMock;

    /**
     * @var \FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\Plugin\SearchExtension\StockStatusQueryExpanderPlugin
     */
    protected StockStatusQueryExpanderPlugin $plugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Elastica\Query
     */
    protected MockObject|Query $searchQueryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
     */
    protected MockObject|QueryInterface $queryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\SearchElasticsearch\Query\QueryBuilderInterface
     */
    protected MockObject|QueryBuilderInterface $queryBuilderMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->boolQueryMock = $this->getMockBuilder(BoolQuery::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerClientMock = $this->getMockBuilder(ConditionalAvailabilityProductPageSearchToCustomerClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this->getMockBuilder(ConditionalAvailabilityProductPageSearchFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->matchQueryMock = $this->getMockBuilder(MatchQuery::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->searchQueryMock = $this->getMockBuilder(QueryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryMock = $this->getMockBuilder(Query::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryBuilderMock = $this->getMockBuilder(QueryBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new StockStatusQueryExpanderPlugin();
        $this->plugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testExpandQuery(): void
    {
        $requestParameters = [
            'stock-status' => '1',
        ];

        $availabilityChannel = 'availability-channel';

        $this->searchQueryMock->expects(static::atLeastOnce())
            ->method('getSearchQuery')
            ->willReturn($this->queryMock);

        $this->queryMock->expects(static::atLeastOnce())
            ->method('addAggregation')
            ->willReturn($this->queryMock);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getCustomerClient')
            ->willReturn($this->customerClientMock);

        $this->customerClientMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getAvailabilityChannel')
            ->willReturn($availabilityChannel);

        $this->queryMock->expects(static::atLeastOnce())
            ->method('getQuery')
            ->willReturn($this->boolQueryMock);

        $this->boolQueryMock->expects(static::atLeastOnce())
            ->method('addMust')
            ->willReturnSelf();

        $searchQuery = $this->plugin->expandQuery($this->searchQueryMock, $requestParameters);

        static::assertEquals($this->searchQueryMock, $searchQuery);
    }

    /**
     * @return void
     */
    public function testExpandQueryWithInvalidArgumentException(): void
    {
        $requestParameters = ['stock-status' => '1'];

        $availabilityChannel = 'availability-channel';

        $this->searchQueryMock->expects(static::atLeastOnce())
            ->method('getSearchQuery')
            ->willReturn($this->queryMock);

        $this->queryMock->expects(static::atLeastOnce())
            ->method('addAggregation')
            ->willReturn($this->queryMock);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getCustomerClient')
            ->willReturn($this->customerClientMock);

        $this->customerClientMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getAvailabilityChannel')
            ->willReturn($availabilityChannel);

        $this->queryMock->expects(static::atLeastOnce())
            ->method('getQuery')
            ->willReturn(new Term());

        $this->expectException(InvalidArgumentException::class);

        $this->plugin->expandQuery($this->searchQueryMock, $requestParameters);
    }

    /**
     * @return void
     */
    public function testExpandQueryWithMissingCustomer(): void
    {
        $requestParameters = ['stock-status' => '1'];

        $this->searchQueryMock->expects(static::atLeastOnce())
            ->method('getSearchQuery')
            ->willReturn($this->queryMock);

        $this->queryMock->expects(static::atLeastOnce())
            ->method('addAggregation')
            ->willReturn($this->queryMock);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getCustomerClient')
            ->willReturn($this->customerClientMock);

        $this->customerClientMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn(null);

        $searchQuery = $this->plugin->expandQuery($this->searchQueryMock, $requestParameters);

        static::assertEquals($this->searchQueryMock, $searchQuery);
    }
}
