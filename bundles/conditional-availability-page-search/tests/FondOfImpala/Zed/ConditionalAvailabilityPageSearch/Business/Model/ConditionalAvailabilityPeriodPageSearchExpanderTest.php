<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToStoreFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearchExtension\Dependency\Plugin\ConditionalAvailabilityPeriodPageDataExpanderPluginInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer;
use Generated\Shared\Transfer\StoreTransfer;

class ConditionalAvailabilityPeriodPageSearchExpanderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchExpander
     */
    protected $conditionalAvailabilityPeriodPageSearchExpander;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToStoreFacadeInterface
     */
    protected $conditionalAvailabilityPageSearchToStoreFacadeInterfaceMock;

    /**
     * @var array<\FondOfImpala\Zed\ConditionalAvailabilityPageSearchExtension\Dependency\Plugin\ConditionalAvailabilityPeriodPageDataExpanderPluginInterface>
     */
    protected $conditionalAvailabilityPeriodPageDataExpanderPlugins;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer
     */
    protected $conditionalAvailabilityPeriodPageSearchTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityPageSearchExtension\Dependency\Plugin\ConditionalAvailabilityPeriodPageDataExpanderPluginInterface
     */
    protected $conditionalAvailabilityPeriodPageDataExpanderPluginInterfaceMock;

    /**
     * @var string
     */
    protected $startAt;

    /**
     * @var string
     */
    protected $endAt;

    /**
     * @var int
     */
    protected $idConditionalAvailability;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\StoreTransfer
     */
    protected $storeTransferMock;

    /**
     * @var string
     */
    protected $storeName;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->conditionalAvailabilityPageSearchToStoreFacadeInterfaceMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchToStoreFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodPageDataExpanderPluginInterfaceMock = $this->getMockBuilder(ConditionalAvailabilityPeriodPageDataExpanderPluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodPageDataExpanderPlugins = [
            $this->conditionalAvailabilityPeriodPageDataExpanderPluginInterfaceMock,
        ];

        $this->conditionalAvailabilityPeriodPageSearchTransferMock = $this->getMockBuilder(ConditionalAvailabilityPeriodPageSearchTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->startAt = 'start-at';

        $this->endAt = 'end-at';

        $this->idConditionalAvailability = 1;

        $this->storeTransferMock = $this->getMockBuilder(StoreTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeName = 'store-name';

        $this->conditionalAvailabilityPeriodPageSearchExpander = new ConditionalAvailabilityPeriodPageSearchExpander(
            $this->conditionalAvailabilityPageSearchToStoreFacadeInterfaceMock,
            $this->conditionalAvailabilityPeriodPageDataExpanderPlugins,
        );
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects($this->atLeastOnce())
            ->method('getStartAt')
            ->willReturn($this->startAt);

        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects($this->atLeastOnce())
            ->method('getEndAt')
            ->willReturn($this->endAt);

        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects($this->atLeastOnce())
            ->method('getFkConditionalAvailability')
            ->willReturn($this->idConditionalAvailability);

        $this->conditionalAvailabilityPageSearchToStoreFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getCurrentStore')
            ->willReturn($this->storeTransferMock);

        $this->storeTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($this->storeName);

        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects($this->atLeastOnce())
            ->method('setConditionalAvailabilityPeriodKey')
            ->willReturnSelf();

        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects($this->atLeastOnce())
            ->method('setStoreName')
            ->with($this->storeName)
            ->willReturnSelf();

        $this->conditionalAvailabilityPeriodPageDataExpanderPluginInterfaceMock->expects($this->atLeastOnce())
            ->method('expand')
            ->with($this->conditionalAvailabilityPeriodPageSearchTransferMock)
            ->willReturn($this->conditionalAvailabilityPeriodPageSearchTransferMock);

        $this->assertInstanceOf(
            ConditionalAvailabilityPeriodPageSearchTransfer::class,
            $this->conditionalAvailabilityPeriodPageSearchExpander->expand(
                $this->conditionalAvailabilityPeriodPageSearchTransferMock,
            ),
        );
    }
}
