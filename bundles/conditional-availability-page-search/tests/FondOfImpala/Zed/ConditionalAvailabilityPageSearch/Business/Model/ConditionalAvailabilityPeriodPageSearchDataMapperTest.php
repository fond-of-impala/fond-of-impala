<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToStoreFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearchExtension\Dependency\Plugin\ConditionalAvailabilityPeriodPageSearchDataExpanderPluginInterface;
use Generated\Shared\Transfer\StoreTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityPeriodPageSearchDataMapperTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchDataMapper
     */
    protected ConditionalAvailabilityPeriodPageSearchDataMapper $mapper;

    /**
     * @var array<int,\FondOfImpala\Zed\ConditionalAvailabilityPageSearchExtension\Dependency\Plugin\ConditionalAvailabilityPeriodPageSearchDataExpanderPluginInterface>
     */
    protected $pluginMocks;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToStoreFacadeInterface
     */
    protected MockObject|ConditionalAvailabilityPageSearchToStoreFacadeInterface $storeFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\StoreTransfer
     */
    protected MockObject|StoreTransfer $storeTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->storeFacadeMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchToStoreFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeTransferMock = $this->getMockBuilder(StoreTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->pluginMocks = [
            $this->getMockBuilder(ConditionalAvailabilityPeriodPageSearchDataExpanderPluginInterface::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->mapper = new ConditionalAvailabilityPeriodPageSearchDataMapper($this->storeFacadeMock, $this->pluginMocks);
    }

    /**
     * @return void
     */
    public function testMapConditionalAvailabilityPeriodDataToSearchData(): void
    {
        $this->storeFacadeMock->expects($this->atLeastOnce())
            ->method('getCurrentStore')
            ->willReturn($this->storeTransferMock);

        $this->storeTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn('store');

        $this->pluginMocks[0]->expects($this->atLeastOnce())
            ->method('expand')
            ->willReturnArgument(1);

        $searchData = $this->mapper
            ->mapConditionalAvailabilityPeriodDataToSearchData([
                'sku' => 'sku',
                'warehouse_group' => 'warehouse-group',
                'quantity' => 1,
                'original_start_at' => '2020-01-01 00:00:00.000000',
                'start_at' => '2020-02-01 00:00:00.000000',
                'end_at' => '2020-02-29 00:00:00.000000',
                'store' => 'store',
            ],
        );

        static::assertArrayHasKey('start-at', $searchData);
        static::assertArrayHasKey('end-at', $searchData);
    }
}
