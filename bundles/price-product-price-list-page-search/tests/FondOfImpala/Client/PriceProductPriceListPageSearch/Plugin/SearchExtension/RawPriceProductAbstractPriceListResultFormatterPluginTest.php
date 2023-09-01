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
    /**
     * @var \FondOfImpala\Client\PriceProductPriceListPageSearch\Plugin\SearchExtension\RawPriceProductAbstractPriceListResultFormatterPlugin
     */
    protected RawPriceProductAbstractPriceListResultFormatterPlugin $rawPriceProductAbstractPriceListResultFormatterPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Elastica\ResultSet
     */
    protected MockObject|ResultSet $resultSetMock;

    /**
     * @var array
     */
    protected array $requestParameters;

    /**
     * @var array
     */
    protected array $results;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Elastica\Result
     */
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

        $this->requestParameters = [

        ];

        $this->resultMock = $this->getMockBuilder(Result::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->results = [
            $this->resultMock,
        ];

        $this->rawPriceProductAbstractPriceListResultFormatterPlugin = new RawPriceProductAbstractPriceListResultFormatterPlugin();
    }

    /**
     * @return void
     */
    public function testGetName(): void
    {
        static::assertSame('price_product_abstract_price_lists', $this->rawPriceProductAbstractPriceListResultFormatterPlugin->getName());
    }

    /**
     * @return void
     */
    public function testFormatSearchResult(): void
    {
        $reflectionMethod = $this->getReflectionMethodByName('formatSearchResult');

        $this->resultSetMock->expects(static::atLeastOnce())
            ->method('getResults')
            ->willReturn($this->results);

        $this->resultMock->expects(static::atLeastOnce())
            ->method('getSource')
            ->willReturn([PriceProductPriceListIndexMap::SEARCH_RESULT_DATA => []]);

        static::assertIsArray($reflectionMethod->invokeArgs($this->rawPriceProductAbstractPriceListResultFormatterPlugin, [$this->resultSetMock, $this->requestParameters]));
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
