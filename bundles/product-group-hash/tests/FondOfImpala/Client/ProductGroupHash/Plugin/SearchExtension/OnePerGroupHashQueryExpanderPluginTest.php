<?php

namespace FondOfImpala\Client\ProductGroupHash\Plugin\SearchExtension;

use Codeception\Test\Unit;
use Elastica\Aggregation\Cardinality;
use Elastica\Collapse;
use Elastica\Param;
use Elastica\Query;
use FondOfImpala\Shared\ProductGroupHash\ProductGroupHashConstants;
use Generated\Shared\Search\PageIndexMap;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

class OnePerGroupHashQueryExpanderPluginTest extends Unit
{
    protected QueryInterface|MockObject $queryMock;

    protected Query|MockObject $elasticaQueryMock;

    protected OnePerGroupHashQueryExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->queryMock = $this->getMockBuilder(QueryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->elasticaQueryMock = $this->getMockBuilder(Query::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new OnePerGroupHashQueryExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpandQuery(): void
    {
        $requestParameters = [ProductGroupHashConstants::PARAMETER_ONE_PER_GROUP_HASH => 'true'];

        $this->queryMock->expects(static::atLeastOnce())
            ->method('getSearchQuery')
            ->willReturn($this->elasticaQueryMock);

        $this->elasticaQueryMock->expects(static::atLeastOnce())
            ->method('setCollapse')
            ->with(
                static::callback(
                    static fn (Collapse $collapse): bool => $collapse->hasParam('field')
                        && $collapse->getParam('field') === PageIndexMap::GROUP_HASH
                        && $collapse->hasParam('inner_hits')
                        && $collapse->getParam('inner_hits')->hasParam('name')
                        && $collapse->getParam('inner_hits')->getParam('name') === ProductGroupHashConstants::INNER_HITS_NAME,
                ),
            )->willReturn($this->elasticaQueryMock);

        $this->elasticaQueryMock->expects(static::atLeastOnce())
            ->method('addAggregation')
            ->with(
                static::callback(
                    static fn (Cardinality $cardinality): bool => $cardinality->getName() === OnePerGroupHashQueryExpanderPlugin::AGGREGATION_NAME_TOTAL_COLLAPSED_HITS
                        && $cardinality->hasParam('field')
                        && $cardinality->getParam('field') === PageIndexMap::GROUP_HASH,
                ),
            )->willReturn($this->elasticaQueryMock);

        static::assertEquals(
            $this->queryMock,
            $this->plugin->expandQuery($this->queryMock, $requestParameters),
        );
    }

    /**
     * @return void
     */
    public function testExpandQueryWithInvalidRequestParameters(): void
    {
        $requestParameters = [ProductGroupHashConstants::PARAMETER_ONE_PER_GROUP_HASH => 'truee'];

        $this->queryMock->expects(static::never())
            ->method('getSearchQuery');

        static::assertEquals(
            $this->queryMock,
            $this->plugin->expandQuery($this->queryMock, $requestParameters),
        );
    }

    /**
     * @return void
     */
    public function testExpandQueryWithInvalidSearchQuery(): void
    {
        $requestParameters = [ProductGroupHashConstants::PARAMETER_ONE_PER_GROUP_HASH => 'true'];

        $searchQueryMock = $this->getMockBuilder(Param::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryMock->expects(static::atLeastOnce())
            ->method('getSearchQuery')
            ->willReturn($searchQueryMock);

        try {
            $this->plugin->expandQuery($this->queryMock, $requestParameters);
            static::fail();
        } catch (InvalidArgumentException) {
        }
    }
}
