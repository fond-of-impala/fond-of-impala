<?php

namespace FondOfImpala\Zed\CustomerPriceList\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CustomerPriceList\Business\Model\CustomerExpanderInterface;
use FondOfImpala\Zed\CustomerPriceList\Business\Model\CustomerPriceListReaderInterface;
use FondOfImpala\Zed\CustomerPriceList\Persistence\CustomerPriceListRepository;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerPriceListBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CustomerPriceList\Business\CustomerPriceListBusinessFactory
     */
    protected CustomerPriceListBusinessFactory $customerPriceListBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CustomerPriceList\Persistence\CustomerPriceListRepository
     */
    protected MockObject|CustomerPriceListRepository $customerPriceListRepositoryMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->customerPriceListRepositoryMock = $this->getMockBuilder(CustomerPriceListRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerPriceListBusinessFactory = new CustomerPriceListBusinessFactory();
        $this->customerPriceListBusinessFactory->setRepository($this->customerPriceListRepositoryMock);
    }

    /**
     * @return void
     */
    public function testCreateCustomerExpander(): void
    {
        $this->assertInstanceOf(
            CustomerExpanderInterface::class,
            $this->customerPriceListBusinessFactory->createCustomerExpander(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCustomerPriceListReader(): void
    {
        $this->assertInstanceOf(
            CustomerPriceListReaderInterface::class,
            $this->customerPriceListBusinessFactory->createCustomerPriceListReader(),
        );
    }
}
