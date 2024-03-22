<?php

namespace FondOfImpala\Client\EnhancedCatalog;

use Codeception\Test\Unit;
use FondOfImpala\Client\EnhancedCatalog\Formatter\RawCatalogSearchResultFormatter;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Kernel\Container;

class EnhancedCatalogFactoryTest extends Unit
{
    protected Container|MockObject $containerMock;

    protected EnhancedCatalogFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new EnhancedCatalogFactory();
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateRawCatalogSearchResultFormatter(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->with(EnhancedCatalogDependencyProvider::PLUGINS_PRODUCT_EXPANDER)
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(EnhancedCatalogDependencyProvider::PLUGINS_PRODUCT_EXPANDER)
            ->willReturn([]);

        static::assertInstanceOf(
            RawCatalogSearchResultFormatter::class,
            $this->factory->createRawCatalogSearchResultFormatter(),
        );
    }
}
