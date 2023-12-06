<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearchExtension\Dependency\Plugin\ConditionalAvailabilityPeriodPageDataExpanderPluginInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityPeriodPageSearchExpanderTest extends Unit
{
    protected MockObject|ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransferMock;

    protected MockObject|ConditionalAvailabilityPeriodPageDataExpanderPluginInterface $conditionalAvailabilityPeriodPageDataExpanderPluginMock;

    protected ConditionalAvailabilityPeriodPageSearchExpander $expander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->conditionalAvailabilityPeriodPageDataExpanderPluginMock = $this->getMockBuilder(ConditionalAvailabilityPeriodPageDataExpanderPluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodPageSearchTransferMock = $this->getMockBuilder(ConditionalAvailabilityPeriodPageSearchTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expander = new ConditionalAvailabilityPeriodPageSearchExpander(
            [$this->conditionalAvailabilityPeriodPageDataExpanderPluginMock],
        );
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $data = ['key' => sha1('foo')];

        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects(static::atLeastOnce())
            ->method('getData')
            ->willReturn($data);

        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects(static::atLeastOnce())
            ->method('setConditionalAvailabilityPeriodKey')
            ->with($data['key'])
            ->willReturn($this->conditionalAvailabilityPeriodPageSearchTransferMock);

        $this->conditionalAvailabilityPeriodPageDataExpanderPluginMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->conditionalAvailabilityPeriodPageSearchTransferMock)
            ->willReturn($this->conditionalAvailabilityPeriodPageSearchTransferMock);

        static::assertEquals(
            $this->conditionalAvailabilityPeriodPageSearchTransferMock,
            $this->expander->expand($this->conditionalAvailabilityPeriodPageSearchTransferMock),
        );
    }
}
