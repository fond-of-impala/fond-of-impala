<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\AllowedProductQuantityCartConnectorConfig;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\AllowedProductQuantityCartConnectorDependencyProvider;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Validator\QuoteValidator;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Dependency\Facade\AllowedProductQuantityCartConnectorToAllowedProductQuantityFacadeInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class AllowedProductQuantityCartConnectorBusinessFactoryTest extends Unit
{
    protected AllowedProductQuantityCartConnectorBusinessFactory $allowedProductQuantityCartConnectorBusinessFactory;

    protected MockObject|AllowedProductQuantityCartConnectorConfig $configMock;

    protected MockObject|Container $containerMock;

    protected MockObject|AllowedProductQuantityCartConnectorToAllowedProductQuantityFacadeInterface $allowedProductQuantityFacadeMock;

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
