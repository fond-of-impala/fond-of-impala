<?php

namespace FondOfImpala\Client\ProductGroupHash\Plugin\SearchExtension;

use Codeception\Test\Unit;
use Elastica\Query;
use Elastica\Query\BoolQuery;
use Elastica\Query\MatchQuery;
use Elastica\Query\Terms;
use FondOfImpala\Shared\ProductGroupHash\ProductGroupHashConstants;
use Generated\Shared\Search\PageIndexMap;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

class GroupHashQueryExpanderPluginTest extends Unit
{
    protected QueryInterface|MockObject $queryMock;

    protected Query|MockObject $elasticaQueryMock;

    protected MockObject|BoolQuery $boolQueryMock;

    protected MatchQuery|MockObject $matchQueryMock;

    protected GroupHashQueryExpanderPlugin $plugin;

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

        $this->boolQueryMock = $this->getMockBuilder(BoolQuery::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->matchQueryMock = $this->getMockBuilder(MatchQuery::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new GroupHashQueryExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpandQuery(): void
    {
        $groupHashes = [
            sha1('foo'),
            sha1('bar'),
        ];

        $requestParameters = [ProductGroupHashConstants::PARAMETER_GROUP_HASH => $groupHashes];

        $this->queryMock->expects(static::atLeastOnce())
            ->method('getSearchQuery')
            ->willReturn($this->elasticaQueryMock);

        $this->elasticaQueryMock->expects(static::atLeastOnce())
            ->method('getQuery')
            ->willReturn($this->boolQueryMock);

        $this->boolQueryMock->expects(static::atLeastOnce())
            ->method('addMust')
            ->with(
                static::callback(
                    static fn (Terms $terms): bool => $terms->hasParam(PageIndexMap::GROUP_HASH)
                        && $terms->getParam(PageIndexMap::GROUP_HASH) === $groupHashes,
                ),
            )->willReturn($this->boolQueryMock);

        static::assertEquals(
            $this->queryMock,
            $this->plugin->expandQuery($this->queryMock, $requestParameters),
        );
    }

    /**
     * @return void
     */
    public function testExpandQueryWithEmptyRequestParameters(): void
    {
        $requestParameters = [];

        $this->queryMock->expects(static::never())
            ->method('getSearchQuery')
            ->willReturn($this->elasticaQueryMock);

        $this->plugin->expandQuery($this->queryMock, $requestParameters);

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
        $groupHash = sha1('foo');

        $requestParameters = [ProductGroupHashConstants::PARAMETER_GROUP_HASH => $groupHash];

        $this->queryMock->expects(static::never())
            ->method('getSearchQuery');

        $this->plugin->expandQuery($this->queryMock, $requestParameters);

        static::assertEquals(
            $this->queryMock,
            $this->plugin->expandQuery($this->queryMock, $requestParameters),
        );
    }

    /**
     * @return void
     */
    public function testExpandQueryWithMatchQueryInsteadOfBoolQuery(): void
    {
        $groupHashes = [
            sha1('foo'),
            sha1('bar'),
        ];

        $requestParameters = [ProductGroupHashConstants::PARAMETER_GROUP_HASH => $groupHashes];

        $this->queryMock->expects(static::atLeastOnce())
            ->method('getSearchQuery')
            ->willReturn($this->elasticaQueryMock);

        $this->elasticaQueryMock->expects(static::atLeastOnce())
            ->method('getQuery')
            ->willReturn($this->matchQueryMock);

        try {
            $this->plugin->expandQuery($this->queryMock, $requestParameters);
            static::fail();
        } catch (InvalidArgumentException) {
        }
    }

    /**
     * @return void
     */
    public function testExpandQueryWithArrayInsteadOfBoolQuery(): void
    {
        $groupHashes = [
            sha1('foo'),
            sha1('bar'),
        ];

        $requestParameters = [ProductGroupHashConstants::PARAMETER_GROUP_HASH => $groupHashes];

        $this->queryMock->expects(static::atLeastOnce())
            ->method('getSearchQuery')
            ->willReturn($this->elasticaQueryMock);

        $this->elasticaQueryMock->expects(static::atLeastOnce())
            ->method('getQuery')
            ->willReturn([$this->matchQueryMock]);

        try {
            $this->plugin->expandQuery($this->queryMock, $requestParameters);
            static::fail();
        } catch (InvalidArgumentException) {
        }
    }
}
