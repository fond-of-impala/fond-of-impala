<?php

namespace FondOfImpala\Client\PriceProductPriceListPageSearch\Plugin\SearchExtension;

use Codeception\Test\Unit;
use Elastica\Result;
use Elastica\ResultSet;
use Generated\Shared\Search\PriceProductPriceListIndexMap;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionClass;
use ReflectionMethod;

class RawPriceProductConcretePriceListResultFormatterPluginTest extends Unit
{
    protected RawPriceProductConcretePriceListResultFormatterPlugin $rawPriceProductConcretePriceListSearchResultFormatterPlugin;

    protected MockObject|ResultSet $resultSetMock;

    protected MockObject|Result $resultMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->resultSetMock = $this->getMockBuilder(ResultSet::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->resultMock = $this->getMockBuilder(Result::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->rawPriceProductConcretePriceListSearchResultFormatterPlugin = new RawPriceProductConcretePriceListResultFormatterPlugin();
    }

    /**
     * @return void
     */
    public function testGetName(): void
    {
        static::assertEquals(
            'price_product_concrete_price_lists',
            $this->rawPriceProductConcretePriceListSearchResultFormatterPlugin->getName(),
        );
    }

    /**
     * @return void
     */
    public function testFormatSearchResult(): void
    {
        $reflectionMethodByName = $this->getReflectionMethodByName('formatSearchResult');

        $this->resultSetMock->expects(static::atLeastOnce())
            ->method('getResults')
            ->willReturn([$this->resultMock]);

        $this->resultMock->expects(static::atLeastOnce())
            ->method('getSource')
            ->willReturn([PriceProductPriceListIndexMap::SEARCH_RESULT_DATA => []]);

        static::assertIsArray(
            $reflectionMethodByName->invokeArgs(
                $this->rawPriceProductConcretePriceListSearchResultFormatterPlugin,
                [$this->resultSetMock, []],
            ),
        );
    }

    /**
     * @param string $name
     *
     * @return \ReflectionMethod
     */
    protected function getReflectionMethodByName(string $name): ReflectionMethod
    {
        $reflectionClass = new ReflectionClass(RawPriceProductConcretePriceListResultFormatterPlugin::class);

        $reflectionMethod = $reflectionClass->getMethod($name);
        $reflectionMethod->setAccessible(true);

        return $reflectionMethod;
    }
}
