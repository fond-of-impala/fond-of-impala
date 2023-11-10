<?php

namespace FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\Plugin\SearchExtension;

use Codeception\Test\Unit;
use Elastica\ResultSet;
use FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\ConditionalAvailabilityProductPageSearchFactory;
use FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\Dependency\Client\ConditionalAvailabilityProductPageSearchToCustomerClientInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class StockStatusResultFormatterPluginTest extends Unit
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
    protected StockStatusResultFormatterPlugin $plugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Elastica\ResultSet
     */
    protected MockObject|ResultSet $elasticaResultSetMock;

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

        $this->elasticaResultSetMock = $this->getMockBuilder(ResultSet::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new StockStatusResultFormatterPlugin();
        $this->plugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testExpandQuery(): void
    {
        $requestParameters = [];
        $stockStatusAggregation = [
            'buckets' => [
                0 => [
                    'key' => 'availabilityChannel-1',
                    'doc_count' => 1,
                ],
            ],
        ];

        $availabilityChannel = 'availabilityChannel';

        $this->elasticaResultSetMock->expects(static::atLeastOnce())
            ->method('getAggregation')
            ->with('stock-status')
            ->willReturn($stockStatusAggregation);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getCustomerClient')
            ->willReturn($this->customerClientMock);

        $this->customerClientMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getAvailabilityChannel')
            ->willReturn($availabilityChannel);

        $result = $this->plugin
            ->formatResult($this->elasticaResultSetMock, $requestParameters);

        static::assertIsArray($result);
        static::assertNotEmpty($result['stock-status']);
    }

    /**
     * @return void
     */
    public function testExpandQueryWithNoStockStatusAggregation(): void
    {
        $requestParameters = [];
        $stockStatusAggregation = [];

        $this->elasticaResultSetMock->expects(static::atLeastOnce())
            ->method('getAggregation')
            ->with('stock-status')
            ->willReturn($stockStatusAggregation);

        $result = $this->plugin
            ->formatResult($this->elasticaResultSetMock, $requestParameters);

        static::assertIsArray($result);
        static::assertEmpty($result);
    }

    /**
     * @return void
     */
    public function testExpandQueryWithNoCustomer(): void
    {
        $requestParameters = [];
        $stockStatusAggregation = [
            'buckets' => [
                0 => [
                    'key' => 'availabilityChannel-1',
                    'doc_count' => 1,
                ],
            ],
        ];

        $this->elasticaResultSetMock->expects(static::atLeastOnce())
            ->method('getAggregation')
            ->with('stock-status')
            ->willReturn($stockStatusAggregation);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getCustomerClient')
            ->willReturn($this->customerClientMock);

        $this->customerClientMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn(null);

        $result = $this->plugin
            ->formatResult($this->elasticaResultSetMock, $requestParameters);

        static::assertIsArray($result);
        static::assertEmpty($result);
    }

    /**
     * @return void
     */
    public function testExpandQueryWithWrongAvailabilityChannel(): void
    {
        $requestParameters = [];
        $stockStatusAggregation = [
            'buckets' => [
                0 => [
                    'key' => 'availabilityChannel2-1',
                    'doc_count' => 1,
                ],
            ],
        ];

        $availabilityChannel = 'availabilityChannel';

        $this->elasticaResultSetMock->expects(static::atLeastOnce())
            ->method('getAggregation')
            ->with('stock-status')
            ->willReturn($stockStatusAggregation);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getCustomerClient')
            ->willReturn($this->customerClientMock);

        $this->customerClientMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getAvailabilityChannel')
            ->willReturn($availabilityChannel);

        $result = $this->plugin
            ->formatResult($this->elasticaResultSetMock, $requestParameters);

        static::assertIsArray($result);
        static::assertNotEmpty($result['stock-status']);
    }

    /**
     * @return void
     */
    public function testGetName(): void
    {
        $this->assertEquals('facets', $this->plugin->getName());
    }
}
