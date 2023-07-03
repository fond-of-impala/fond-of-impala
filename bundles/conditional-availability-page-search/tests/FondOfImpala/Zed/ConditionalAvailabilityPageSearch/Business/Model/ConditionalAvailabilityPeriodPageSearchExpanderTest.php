<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToStoreFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearchExtension\Dependency\Plugin\ConditionalAvailabilityPeriodPageDataExpanderPluginInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityPeriodPageSearchExpanderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchExpander
     */
    protected ConditionalAvailabilityPeriodPageSearchExpander $expander;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToStoreFacadeInterface
     */
    protected MockObject|ConditionalAvailabilityPageSearchToStoreFacadeInterface $storeFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer
     */
    protected MockObject|ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityPageSearchExtension\Dependency\Plugin\ConditionalAvailabilityPeriodPageDataExpanderPluginInterface
     */
    protected MockObject|ConditionalAvailabilityPeriodPageDataExpanderPluginInterface $conditionalAvailabilityPeriodPageDataExpanderPluginMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\StoreTransfer
     */
    protected MockObject|StoreTransfer $storeTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->storeFacadeMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchToStoreFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodPageDataExpanderPluginMock = $this->getMockBuilder(ConditionalAvailabilityPeriodPageDataExpanderPluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodPageSearchTransferMock = $this->getMockBuilder(ConditionalAvailabilityPeriodPageSearchTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeTransferMock = $this->getMockBuilder(StoreTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expander = new ConditionalAvailabilityPeriodPageSearchExpander(
            $this->storeFacadeMock,
            [$this->conditionalAvailabilityPeriodPageDataExpanderPluginMock],
        );
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $startAt = '1970-01-01';
        $endAt = '1970-01-02';
        $idConditionalAvailability = 1;
        $storeName = 'store-name';

        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn($startAt);

        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn($endAt);

        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects(static::atLeastOnce())
            ->method('getFkConditionalAvailability')
            ->willReturn($idConditionalAvailability);

        $this->storeFacadeMock->expects(static::atLeastOnce())
            ->method('getCurrentStore')
            ->willReturn($this->storeTransferMock);

        $this->storeTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn($storeName);

        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects(static::atLeastOnce())
            ->method('setConditionalAvailabilityPeriodKey')
            ->willReturnSelf();

        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects(static::atLeastOnce())
            ->method('setStoreName')
            ->with($storeName)
            ->willReturnSelf();

        $this->conditionalAvailabilityPeriodPageDataExpanderPluginMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->conditionalAvailabilityPeriodPageSearchTransferMock)
            ->willReturn($this->conditionalAvailabilityPeriodPageSearchTransferMock);

        static::assertInstanceOf(
            ConditionalAvailabilityPeriodPageSearchTransfer::class,
            $this->expander->expand($this->conditionalAvailabilityPeriodPageSearchTransferMock),
        );
    }
}
