<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\AllowedProductQuantityCartConnectorConfig;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\AllowedProductQuantityCartConnectorDependencyProvider;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Validator\QuoteValidator;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Dependency\Facade\AllowedProductQuantityCartConnectorToAllowedProductQuantityFacadeInterface;
use Spryker\Zed\Kernel\Container;

class AllowedProductQuantityCartConnectorBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\AllowedProductQuantityCartConnectorBusinessFactory
     */
    protected $allowedProductQuantityCartConnectorBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\AllowedProductQuantityCartConnector\AllowedProductQuantityCartConnectorConfig
     */
    protected $configMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\AllowedProductQuantityCartConnector\Dependency\Facade\AllowedProductQuantityCartConnectorToAllowedProductQuantityFacadeInterface
     */
    protected $allowedProductQuantityFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->configMock = $this->getMockBuilder(AllowedProductQuantityCartConnectorConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityFacadeMock = $this->getMockBuilder(AllowedProductQuantityCartConnectorToAllowedProductQuantityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityCartConnectorBusinessFactory = new AllowedProductQuantityCartConnectorBusinessFactory();
        $this->allowedProductQuantityCartConnectorBusinessFactory->setContainer($this->containerMock);
        $this->allowedProductQuantityCartConnectorBusinessFactory->setConfig($this->configMock);
    }

    /**
     * @return void
     */
    public function testCreateQuoteValidator(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [AllowedProductQuantityCartConnectorDependencyProvider::FACADE_ALLOWED_PRODUCT_QUANTITY],
                [AllowedProductQuantityCartConnectorDependencyProvider::FACADE_ALLOWED_PRODUCT_QUANTITY],
            )
            ->willReturnOnConsecutiveCalls(
                $this->allowedProductQuantityFacadeMock,
                $this->allowedProductQuantityFacadeMock,
            );

        static::assertInstanceOf(
            QuoteValidator::class,
            $this->allowedProductQuantityCartConnectorBusinessFactory->createQuoteValidator(),
        );
    }
}
