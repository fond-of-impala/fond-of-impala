<?php

namespace FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\Plugin\EnhancedCatalogExtension;

use Codeception\Test\Unit;
use Elastica\Result;
use FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\ConditionalAvailabilityProductPageSearchFactory;
use FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\Dependency\Client\ConditionalAvailabilityProductPageSearchToCustomerClientInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class StockStatusProductExpanderPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\Dependency\Client\ConditionalAvailabilityProductPageSearchToCustomerClientInterface
     */
    protected MockObject|ConditionalAvailabilityProductPageSearchToCustomerClientInterface $customerClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected MockObject|CustomerTransfer $customerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\ConditionalAvailabilityProductPageSearchFactory
     */
    protected MockObject|ConditionalAvailabilityProductPageSearchFactory $factoryMock;

    /**
     * @var \FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\Plugin\SearchExtension\StockStatusResultFormatterPlugin
     */
    protected StockStatusProductExpanderPlugin $plugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Elastica\Result
     */
    protected MockObject|Result $elasticaResultMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->customerClientMock = $this->getMockBuilder(ConditionalAvailabilityProductPageSearchToCustomerClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this->getMockBuilder(ConditionalAvailabilityProductPageSearchFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->elasticaResultMock = $this->getMockBuilder(Result::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new StockStatusProductExpanderPlugin();
        $this->plugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $product = [
            'stock_status' => [
                'channel-1',
            ],
        ];

        $availabilityChannel = 'channel';

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getCustomerClient')
            ->willReturn($this->customerClientMock);

        $this->customerClientMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getAvailabilityChannel')
            ->willReturn($availabilityChannel);

        $product = $this->plugin->expand($product, $this->elasticaResultMock);

        static::assertIsArray($product);
        static::assertIsInt($product['stock_status']);
        static::assertEquals(1, $product['stock_status']);
    }

    /**
     * @return void
     */
    public function testExpandWithMissingStockStatus(): void
    {
        $product = [];

        $product = $this->plugin->expand($product, $this->elasticaResultMock);

        static::assertIsArray($product);
        static::assertIsInt($product['stock_status']);
        static::assertEquals(0, $product['stock_status']);
    }

    /**
     * @return void
     */
    public function testExpandWithMissingCustomer(): void
    {
        $product = [
            'stock_status' => [
                'channel-1',
            ],
        ];

        $availabilityChannel = 'channel';

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getCustomerClient')
            ->willReturn($this->customerClientMock);

        $this->customerClientMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn(null);

        $product = $this->plugin->expand($product, $this->elasticaResultMock);

        static::assertIsArray($product);
        static::assertIsInt($product['stock_status']);
        static::assertEquals(0, $product['stock_status']);
    }

    /**
     * @return void
     */
    public function testExpandWithMissingChannel(): void
    {
        $product = [
            'stock_status' => [
                'channel-1',
            ],
        ];

        $availabilityChannel = 'availability-channel';

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getCustomerClient')
            ->willReturn($this->customerClientMock);

        $this->customerClientMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getAvailabilityChannel')
            ->willReturn($availabilityChannel);

        $product = $this->plugin->expand($product, $this->elasticaResultMock);

        static::assertIsArray($product);
        static::assertIsInt($product['stock_status']);
        static::assertEquals(0, $product['stock_status']);
    }
}
