<?php

namespace FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\Plugin\SearchExtension;

use Codeception\Test\Unit;
use Elastica\Query;
use Elastica\Query\BoolQuery;
use Elastica\Query\MatchQuery;
use Elastica\Query\Term;
use FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\ConditionalAvailabilityProductPageSearchFactory;
use Generated\Shared\Search\PageIndexMap;
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

        $this->factoryMock = $this->getMockBuilder(ConditionalAvailabilityProductPageSearchFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->matchQueryMock = $this->getMockBuilder(MatchQuery::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->searchQueryMock = $this->getMockBuilder(Query::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryMock = $this->getMockBuilder(QueryInterface::class)
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
            'stock-status' => 'stock-status',
        ];

        $this->queryMock->expects(static::atLeastOnce())
            ->method('getSearchQuery')
            ->willReturn($this->searchQueryMock);

        $this->searchQueryMock->expects(static::atLeastOnce())
            ->method('getQuery')
            ->willReturn($this->boolQueryMock);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createQueryBuilder')
            ->willReturn($this->queryBuilderMock);

        $this->queryBuilderMock->expects(static::atLeastOnce())
            ->method('createMatchQuery')
            ->willReturn($this->matchQueryMock);

        $this->matchQueryMock->expects(static::atLeastOnce())
            ->method('setField')
            ->with(PageIndexMap::STOCK_STATUS, $requestParameters['stock-status'])
            ->willReturnSelf();

        $this->boolQueryMock->expects(static::atLeastOnce())
            ->method('addMust')
            ->with($this->matchQueryMock)
            ->willReturnSelf();

        $query = $this->plugin->expandQuery($this->queryMock, $requestParameters);

        static::assertEquals($this->queryMock, $query);
    }

    /**
     * @return void
     */
    public function testExpandQueryWithInvalidArgumentException(): void
    {
        $requestParameters = [
            'stock-status' => 'stock-status',
        ];

        $this->queryMock->expects(static::atLeastOnce())
            ->method('getSearchQuery')
            ->willReturn($this->searchQueryMock);

        $this->searchQueryMock->expects(static::atLeastOnce())
            ->method('getQuery')
            ->willReturn(new Term());

        $this->expectException(InvalidArgumentException::class);

        $this->plugin->expandQuery($this->queryMock, $requestParameters);
    }
}
