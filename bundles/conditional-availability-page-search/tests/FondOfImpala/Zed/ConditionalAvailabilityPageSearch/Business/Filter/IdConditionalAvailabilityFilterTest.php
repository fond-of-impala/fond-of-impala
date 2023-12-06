<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Filter;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\EventEntityTransfer;

class IdConditionalAvailabilityFilterTest extends Unit
{
    /**
     * @var array<\Generated\Shared\Transfer\EventEntityTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $eventEntityTransferMocks;

    protected IdConditionalAvailabilityFilter $filter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->eventEntityTransferMocks = [
            $this->getMockBuilder(EventEntityTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(EventEntityTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->filter = new IdConditionalAvailabilityFilter();
    }

    /**
     * @return void
     */
    public function testFilterFromEventEntities(): void
    {
        $conditionalAvailabilityIds = [2];

        $this->eventEntityTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn($conditionalAvailabilityIds[0]);

        $this->eventEntityTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn(null);

        static::assertEquals(
            $conditionalAvailabilityIds,
            $this->filter->filterFromEventEntities($this->eventEntityTransferMocks),
        );
    }
}
