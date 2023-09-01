<?php

namespace FondOfImpala\Glue\CustomerPriceList\Plugin\CustomersRestApiExtension;

use Codeception\Test\Unit;
use FondOfImpala\Glue\CustomerPriceList\CustomerPriceListFactory;
use FondOfImpala\Glue\CustomerPriceList\Processor\Expander\CustomerExpanderInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class PriceListCustomerExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\CustomerPriceList\Plugin\CustomersRestApiExtension\PriceListCustomerExpanderPlugin
     */
    protected PriceListCustomerExpanderPlugin $priceListCustomerExpanderPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\CustomerPriceList\CustomerPriceListFactory
     */
    protected MockObject|CustomerPriceListFactory $customerPriceListFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected MockObject|CustomerTransfer $customerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected MockObject|RestRequestInterface $restRequestInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\CustomerPriceList\Processor\Expander\CustomerExpanderInterface
     */
    protected MockObject|CustomerExpanderInterface $customerExpanderInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->customerPriceListFactoryMock = $this->getMockBuilder(CustomerPriceListFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestInterfaceMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerExpanderInterfaceMock = $this->getMockBuilder(CustomerExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListCustomerExpanderPlugin = new PriceListCustomerExpanderPlugin();
        $this->priceListCustomerExpanderPlugin->setFactory($this->customerPriceListFactoryMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->customerPriceListFactoryMock->expects($this->atLeastOnce())
            ->method('createCustomerExpander')
            ->willReturn($this->customerExpanderInterfaceMock);

        $this->customerExpanderInterfaceMock->expects($this->atLeastOnce())
            ->method('expand')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->assertEquals(
            $this->customerTransferMock,
            $this->priceListCustomerExpanderPlugin->expand(
                $this->customerTransferMock,
                $this->restRequestInterfaceMock,
            ),
        );
    }
}
