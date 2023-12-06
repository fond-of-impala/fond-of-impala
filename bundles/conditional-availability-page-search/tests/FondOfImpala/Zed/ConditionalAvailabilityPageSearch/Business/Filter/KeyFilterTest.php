<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Filter;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\EventEntityTransfer;
use Orm\Zed\ConditionalAvailability\Persistence\Map\FoiConditionalAvailabilityPeriodTableMap;

class KeyFilterTest extends Unit
{
    /**
     * @var array<\Generated\Shared\Transfer\EventEntityTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $eventEntityTransferMocks;

    protected KeyFilter $filter;

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

        $this->filter = new KeyFilter();
    }

    /**
     * @return void
     */
    public function testFilterFromEventEntities(): void
    {
        $keys = [sha1('foo')];
        $additionalValues = [
            FoiConditionalAvailabilityPeriodTableMap::COL_KEY => $keys[0],
        ];

        $this->eventEntityTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getAdditionalValues')
            ->willReturn($additionalValues);

        $this->eventEntityTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getAdditionalValues')
            ->willReturn(null);

        static::assertEquals(
            $keys,
            $this->filter->filterFromEventEntities($this->eventEntityTransferMocks),
        );
    }
}
