<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\AllowedProductQuantityCheckoutConnectorDependencyProvider;
use FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Business\Model\CheckoutPreConditionCheckerInterface;
use FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Dependency\Facade\AllowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class AllowedProductQuantityCheckoutConnectorBusinessFactoryTest extends Unit
{
    protected AllowedProductQuantityCheckoutConnectorBusinessFactory $allowedProductQuantityCheckoutConnectorBusinessFactory;

    protected MockObject|Container $containerMock;

    protected MockObject|AllowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeInterface $allowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeInterfaceMock = $this->getMockBuilder(AllowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityCheckoutConnectorBusinessFactory = new AllowedProductQuantityCheckoutConnectorBusinessFactory();
        $this->allowedProductQuantityCheckoutConnectorBusinessFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateCheckoutPerConditionChecker(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(AllowedProductQuantityCheckoutConnectorDependencyProvider::FACADE_ALLOWED_PRODUCT_QUANTITY_CART_CONNECTOR)
            ->willReturn($this->allowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeInterfaceMock);

        $this->assertInstanceOf(CheckoutPreConditionCheckerInterface::class, $this->allowedProductQuantityCheckoutConnectorBusinessFactory->createCheckoutPreConditionChecker());
    }
}
