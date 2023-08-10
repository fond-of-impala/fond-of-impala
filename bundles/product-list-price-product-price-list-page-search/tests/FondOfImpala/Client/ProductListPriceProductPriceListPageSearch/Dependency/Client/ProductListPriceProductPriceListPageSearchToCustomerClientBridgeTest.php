<?php

namespace FondOfImpala\Client\ProductListPriceProductPriceListPageSearch\Dependency\Client;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Client\Customer\CustomerClientInterface;

class ProductListPriceProductPriceListPageSearchToCustomerClientBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Customer\CustomerClientInterface
     */
    protected $customerClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected $customerTransferMock;

    /**
     * @var \FondOfImpala\Client\ProductListPriceProductPriceListPageSearch\Dependency\Client\ProductListPriceProductPriceListPageSearchToCustomerClientBridge
     */
    protected $productListPriceProductPriceListPageSearchToCustomerClientBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->customerClientMock = $this->getMockBuilder(CustomerClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListPriceProductPriceListPageSearchToCustomerClientBridge = new ProductListPriceProductPriceListPageSearchToCustomerClientBridge(
            $this->customerClientMock,
        );
    }

    /**
     * @return void
     */
    public function testGetCustomer(): void
    {
        $this->customerClientMock->expects(self::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        self::assertEquals(
            $this->customerTransferMock,
            $this->productListPriceProductPriceListPageSearchToCustomerClientBridge->getCustomer(),
        );
    }
}
