<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToStoreFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearchExtension\Dependency\Plugin\ConditionalAvailabilityPeriodPageSearchDataExpanderPluginInterface;
use Generated\Shared\Transfer\StoreTransfer;

class ConditionalAvailabilityPeriodPageSearchDataMapperTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchDataMapper
     */
    protected $conditionalAvailabilityPeriodPageSearchDataMapper;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToStoreFacadeInterface
     */
    protected $storeFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\StoreTransfer
     */
    protected $storeTransferMock;

    /**
     * @var array<\FondOfImpala\Zed\ConditionalAvailabilityPageSearchExtension\Dependency\Plugin\ConditionalAvailabilityPeriodPageSearchDataExpanderPluginInterface>|array<\PHPUnit\Framework\MockObject\MockObject>
     */
    protected $conditionalAvailabilityPeriodPageSearchDataExpanderPluginMocks;

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

        $this->conditionalAvailabilityPeriodPageSearchDataExpanderPluginMocks = [
            $this->getMockBuilder(ConditionalAvailabilityPeriodPageSearchDataExpanderPluginInterface::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->conditionalAvailabilityPeriodPageSearchDataMapper = new ConditionalAvailabilityPeriodPageSearchDataMapper(
            $this->storeFacadeMock,
            $this->conditionalAvailabilityPeriodPageSearchDataExpanderPluginMocks,
        );
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

        $this->conditionalAvailabilityPeriodPageSearchDataExpanderPluginMocks[0]->expects($this->atLeastOnce())
            ->method('expand')
            ->willReturnArgument(1);

        $searchData = $this->conditionalAvailabilityPeriodPageSearchDataMapper->mapConditionalAvailabilityPeriodDataToSearchData(
            [
                'sku' => 'SKU',
                'warehouse_group' => 'WG',
                'quantity' => 1,
                'original_start_at' => '2020-01-01 00:00:00.000000',
                'start_at' => '2020-02-01 00:00:00.000000',
                'end_at' => '2020-02-29 00:00:00.000000',
                'is_accessible' => true,
                'store' => 'EROTS',
            ],
        );

        $this->assertArrayHasKey('start-at', $searchData);
        $this->assertArrayHasKey('end-at', $searchData);
        $this->assertArrayHasKey('is-accessible', $searchData);
    }
}
