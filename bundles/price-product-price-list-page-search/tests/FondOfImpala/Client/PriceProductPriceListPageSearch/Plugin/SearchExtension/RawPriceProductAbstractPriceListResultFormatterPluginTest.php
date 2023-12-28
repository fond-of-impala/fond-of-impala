<?php

namespace FondOfImpala\Client\PriceProductPriceListPageSearch\Plugin\SearchExtension;

use Codeception\Test\Unit;
use Elastica\Result;
use Elastica\ResultSet;
use Generated\Shared\Search\PriceProductPriceListIndexMap;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionClass;
use ReflectionMethod;

class RawPriceProductAbstractPriceListResultFormatterPluginTest extends Unit
{
    protected RawPriceProductAbstractPriceListResultFormatterPlugin $rawPriceProductAbstractPriceListResultFormatterPlugin;

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

        $this->rawPriceProductAbstractPriceListResultFormatterPlugin = new RawPriceProductAbstractPriceListResultFormatterPlugin();
    }

    /**
     * @return void
     */
    public function testGetName(): void
    {
        static::assertEquals(
            'price_product_abstract_price_lists',
            $this->rawPriceProductAbstractPriceListResultFormatterPlugin->getName(),
        );
    }

    /**
     * @return void
     */
    public function testFormatSearchResult(): void
    {
        $reflectionMethod = $this->getReflectionMethodByName('formatSearchResult');

        $this->resultSetMock->expects(static::atLeastOnce())
            ->method('getResults')
            ->willReturn([$this->resultMock]);

        $this->resultMock->expects(static::atLeastOnce())
            ->method('getSource')
            ->willReturn([PriceProductPriceListIndexMap::SEARCH_RESULT_DATA => []]);

        static::assertIsArray(
            $reflectionMethod->invokeArgs(
                $this->rawPriceProductAbstractPriceListResultFormatterPlugin,
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
        $reflectionClass = new ReflectionClass(RawPriceProductAbstractPriceListResultFormatterPlugin::class);

        $reflectionMethod = $reflectionClass->getMethod($name);
        $reflectionMethod->setAccessible(true);

        return $reflectionMethod;
    }
}
