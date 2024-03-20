<?php

namespace FondOfImpala\Client\EnhancedCatalog\Formatter;

use Codeception\Test\Unit;
use Elastica\Result;
use Elastica\ResultSet;
use FondOfImpala\Client\EnhancedCatalogExtension\Dependency\Plugin\ProductExpanderPluginInterface;
use Generated\Shared\Search\PageIndexMap;
use PHPUnit\Framework\MockObject\MockObject;

class RawCatalogSearchResultFormatterTest extends Unit
{
    protected ProductExpanderPluginInterface|MockObject $productExpanderPluginMock;

    protected MockObject|ResultSet $resultSetMock;

    protected MockObject|Result $resultMock;

    protected RawCatalogSearchResultFormatter $rawCatalogSearchResultFormatter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->productExpanderPluginMock = $this->getMockBuilder(ProductExpanderPluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->resultSetMock = $this->getMockBuilder(ResultSet::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->resultMock = $this->getMockBuilder(Result::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->rawCatalogSearchResultFormatter = new RawCatalogSearchResultFormatter([
            $this->productExpanderPluginMock
        ]);
    }

    /**
     * @return void
     */
    public function testFormat(): void
    {
        $source = [
            PageIndexMap::SEARCH_RESULT_DATA => [
                'sku' => 'foo',
                '...' => '...'
            ]
        ];

        $this->resultSetMock->expects(static::atLeastOnce())
            ->method('getResults')
            ->willReturn([$this->resultMock]);

        $this->resultMock->expects(static::atLeastOnce())
            ->method('getSource')
            ->willReturn($source);

        $this->productExpanderPluginMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($source[PageIndexMap::SEARCH_RESULT_DATA], $this->resultMock)
            ->willReturn($source[PageIndexMap::SEARCH_RESULT_DATA]);

        static::assertEquals(
            [$source[PageIndexMap::SEARCH_RESULT_DATA]],
            $this->rawCatalogSearchResultFormatter->format($this->resultSetMock, [])
        );
    }

}
