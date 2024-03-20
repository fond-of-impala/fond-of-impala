<?php

namespace FondOfImpala\Client\EnhancedCatalog\Plugin\ResultFormatter;

use Codeception\Test\Unit;
use Elastica\ResultSet;
use FondOfImpala\Client\EnhancedCatalog\EnhancedCatalogFactory;
use FondOfImpala\Client\EnhancedCatalog\Formatter\RawCatalogSearchResultFormatterInterface;
use PHPUnit\Framework\MockObject\MockObject;

class RawCatalogSearchResultFormatterPluginTest extends Unit
{
    protected MockObject|EnhancedCatalogFactory $factoryMock;

    protected MockObject|RawCatalogSearchResultFormatterInterface $rawCatalogSearchResultFormatterMock;

    protected MockObject|ResultSet $resultSetMock;

    protected RawCatalogSearchResultFormatterPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(EnhancedCatalogFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->rawCatalogSearchResultFormatterMock = $this->getMockBuilder(RawCatalogSearchResultFormatterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->resultSetMock = $this->getMockBuilder(ResultSet::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new RawCatalogSearchResultFormatterPlugin();
        $this->plugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testGetName(): void
    {
        static::assertEquals(
            RawCatalogSearchResultFormatterPlugin::NAME,
            $this->plugin->getName()
        );
    }


    /**
     * @return void
     */
    public function testFormatResult(): void
    {
        $products = [
            ['...' => '...']
        ];
        $requestParameters = [];

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createRawCatalogSearchResultFormatter')
            ->willReturn($this->rawCatalogSearchResultFormatterMock);

        $this->rawCatalogSearchResultFormatterMock->expects(static::atLeastOnce())
            ->method('format')
            ->with($this->resultSetMock, $requestParameters)
            ->willReturn($products);

        static::assertEquals(
            $products,
            $this->plugin->formatResult($this->resultSetMock, $requestParameters)
        );
    }
}
