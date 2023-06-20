<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityEntityManagerInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;

class ConditionalAvailabilityPeriodsPersisterTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityEntityManagerInterface
     */
    protected $conditionalAvailabilityEntityManagerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityTransfer
     */
    protected $conditionalAvailabilityTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer
     */
    protected $conditionalAvailabilityPeriodCollectionTransferMock;

    /**
     * @var array<\Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer>|array<\PHPUnit\Framework\MockObject\MockObject>
     */
    protected $conditionalAvailabilityPeriodTransferMocks;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityPeriodsPersister
     */
    protected $conditionalAvailabilityPeriodsPersister;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->conditionalAvailabilityTransferMock = $this->getMockBuilder(ConditionalAvailabilityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodCollectionTransferMock = $this->getMockBuilder(ConditionalAvailabilityPeriodCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodTransferMocks = [
            $this->getMockBuilder(ConditionalAvailabilityPeriodTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->conditionalAvailabilityEntityManagerMock = $this->getMockBuilder(ConditionalAvailabilityEntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodsPersister = new ConditionalAvailabilityPeriodsPersister(
            $this->conditionalAvailabilityEntityManagerMock,
        );
    }

    /**
     * @return void
     */
    public function testPersistWithInvalidConditionalAvailabilityTransfer(): void
    {
        $this->conditionalAvailabilityTransferMock->expects($this->atLeastOnce())
            ->method('getIdConditionalAvailability')
            ->willReturn(null);

        $this->assertEquals(
            $this->conditionalAvailabilityTransferMock,
            $this->conditionalAvailabilityPeriodsPersister->persist($this->conditionalAvailabilityTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testPersistWithoutConditionalAvailabilityPeriodCollection(): void
    {
        $this->conditionalAvailabilityTransferMock->expects($this->atLeastOnce())
            ->method('getIdConditionalAvailability')
            ->willReturn(1);

        $this->conditionalAvailabilityTransferMock->expects($this->atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn(null);

        $this->assertEquals(
            $this->conditionalAvailabilityTransferMock,
            $this->conditionalAvailabilityPeriodsPersister->persist($this->conditionalAvailabilityTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testPersist(): void
    {
        $idConditionalAvailability = 1;

        $this->conditionalAvailabilityTransferMock->expects($this->atLeastOnce())
            ->method('getIdConditionalAvailability')
            ->willReturn($idConditionalAvailability);

        $this->conditionalAvailabilityTransferMock->expects($this->atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn($this->conditionalAvailabilityPeriodCollectionTransferMock);

        $this->conditionalAvailabilityEntityManagerMock->expects($this->atLeastOnce())
            ->method('deleteConditionalAvailabilityPeriodsByConditionalAvailabilityId')
            ->with($idConditionalAvailability);

        $this->conditionalAvailabilityPeriodCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getConditionalAvailabilityPeriods')
            ->willReturn($this->conditionalAvailabilityPeriodTransferMocks);

        $this->conditionalAvailabilityPeriodTransferMocks[0]->expects($this->atLeastOnce())
            ->method('setFkConditionalAvailability')
            ->with($idConditionalAvailability)
            ->willReturn($this->conditionalAvailabilityPeriodTransferMocks[0]);

        $this->conditionalAvailabilityEntityManagerMock->expects($this->atLeastOnce())
            ->method('createConditionalAvailabilityPeriod')
            ->with($this->conditionalAvailabilityPeriodTransferMocks[0]);

        $this->assertEquals(
            $this->conditionalAvailabilityTransferMock,
            $this->conditionalAvailabilityPeriodsPersister->persist($this->conditionalAvailabilityTransferMock),
        );
    }
}
