<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearchExtension\Dependency\Plugin\ConditionalAvailabilityPeriodPageSearchDataExpanderPluginInterface;

class ConditionalAvailabilityPeriodPageSearchDataMapperTest extends Unit
{
    /**
     * @var array<\FondOfImpala\Zed\ConditionalAvailabilityPageSearchExtension\Dependency\Plugin\ConditionalAvailabilityPeriodPageSearchDataExpanderPluginInterface|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $pluginMocks;

    protected ConditionalAvailabilityPeriodPageSearchDataMapper $mapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->pluginMocks = [
            $this->getMockBuilder(ConditionalAvailabilityPeriodPageSearchDataExpanderPluginInterface::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->mapper = new ConditionalAvailabilityPeriodPageSearchDataMapper($this->pluginMocks);
    }

    /**
     * @return void
     */
    public function testMapConditionalAvailabilityPeriodDataToSearchData(): void
    {
        $data = [
            'sku' => 'FOO-1',
            'warehouse_group' => 'FOO',
            'channel' => 'BAR',
            'quantity' => 1,
            'original_start_at' => '2020-01-01 00:00:00.000000',
            'start_at' => '2020-02-01 00:00:00.000000',
            'end_at' => '2020-02-29 00:00:00.000000',
            'store' => 'store',
        ];

        $this->pluginMocks[0]->expects(static::atLeastOnce())
            ->method('expand')
            ->willReturnArgument(1);

        $searchData = $this->mapper->mapConditionalAvailabilityPeriodDataToSearchData($data);

        static::assertArrayHasKey('start-at', $searchData);
        static::assertArrayHasKey('end-at', $searchData);
    }
}
