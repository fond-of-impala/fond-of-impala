<?php

namespace FondOfImpala\Client\CustomerPriceList;

use Codeception\Test\Unit;
use FondOfImpala\Client\CustomerPriceList\Dependency\Client\CustomerPriceListToZedRequestClientInterface;
use FondOfImpala\Client\CustomerPriceList\Zed\CustomerPriceListStubInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Kernel\Container;

class CustomerPriceListFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\CustomerPriceList\CustomerPriceListFactory
     */
    protected CustomerPriceListFactory $customerPriceListFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CustomerPriceList\Dependency\Client\CustomerPriceListToZedRequestClientInterface
     */
    protected MockObject|CustomerPriceListToZedRequestClientInterface $customerPriceListToZedRequestClientInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerPriceListToZedRequestClientInterfaceMock = $this->getMockBuilder(CustomerPriceListToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerPriceListFactory = new CustomerPriceListFactory();
        $this->customerPriceListFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateZedStub(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(CustomerPriceListDependencyProvider::CLIENT_ZED_REQUEST)
            ->willReturn($this->customerPriceListToZedRequestClientInterfaceMock);

        $this->assertInstanceOf(
            CustomerPriceListStubInterface::class,
            $this->customerPriceListFactory->createZedStub(),
        );
    }
}
