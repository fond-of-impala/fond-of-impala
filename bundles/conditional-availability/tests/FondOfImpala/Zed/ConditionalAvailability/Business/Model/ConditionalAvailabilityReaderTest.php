<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityRepositoryInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;

class ConditionalAvailabilityReaderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityRepositoryInterface
     */
    protected $conditionalAvailabilityRepositoryMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityReader
     */
    protected $conditionalAvailabilityReader;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityTransfer
     */
    protected $conditionalAvailabilityTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer
     */
    protected $conditionalAvailabilityCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer
     */
    protected $conditionalAvailabilityCriteriaFilterTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->conditionalAvailabilityCriteriaFilterTransferMock = $this->getMockBuilder(ConditionalAvailabilityCriteriaFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityCollectionTransferMock = $this->getMockBuilder(ConditionalAvailabilityCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityTransferMock = $this->getMockBuilder(ConditionalAvailabilityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityRepositoryMock = $this->getMockBuilder(ConditionalAvailabilityRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityReader = new ConditionalAvailabilityReader(
            $this->conditionalAvailabilityRepositoryMock,
        );
    }

    /**
     * @return void
     */
    public function testFindByIdWithNotExistingDBEntry(): void
    {
        $idConditionalAvailability = 1;

        $this->conditionalAvailabilityTransferMock->expects($this->atLeastOnce())
            ->method('requireIdConditionalAvailability')
            ->willReturn($this->conditionalAvailabilityTransferMock);

        $this->conditionalAvailabilityTransferMock->expects($this->atLeastOnce())
            ->method('getIdConditionalAvailability')
            ->willReturn($idConditionalAvailability);

        $this->conditionalAvailabilityRepositoryMock->expects($this->atLeastOnce())
            ->method('findConditionalAvailabilityById')
            ->with($idConditionalAvailability)
            ->willReturn(null);

        $conditionalAvailabilityResponseTransfer = $this->conditionalAvailabilityReader
            ->findById($this->conditionalAvailabilityTransferMock);

        $this->assertFalse($conditionalAvailabilityResponseTransfer->getIsSuccessful());
        $this->assertEquals(null, $conditionalAvailabilityResponseTransfer->getConditionalAvailabilityTransfer());
    }

    /**
     * @return void
     */
    public function testFindById(): void
    {
        $idConditionalAvailability = 1;

        $this->conditionalAvailabilityTransferMock->expects($this->atLeastOnce())
            ->method('requireIdConditionalAvailability')
            ->willReturn($this->conditionalAvailabilityTransferMock);

        $this->conditionalAvailabilityTransferMock->expects($this->atLeastOnce())
            ->method('getIdConditionalAvailability')
            ->willReturn($idConditionalAvailability);

        $this->conditionalAvailabilityRepositoryMock->expects($this->atLeastOnce())
            ->method('findConditionalAvailabilityById')
            ->with($idConditionalAvailability)
            ->willReturn($this->conditionalAvailabilityTransferMock);

        $conditionalAvailabilityResponseTransfer = $this->conditionalAvailabilityReader
            ->findById($this->conditionalAvailabilityTransferMock);

        $this->assertTrue($conditionalAvailabilityResponseTransfer->getIsSuccessful());
        $this->assertEquals(
            $this->conditionalAvailabilityTransferMock,
            $conditionalAvailabilityResponseTransfer->getConditionalAvailabilityTransfer(),
        );
    }

    /**
     * @return void
     */
    public function testFindAll(): void
    {
        $this->conditionalAvailabilityRepositoryMock->expects($this->atLeastOnce())
            ->method('findConditionalAvailabilities')
            ->withAnyParameters()
            ->willReturn($this->conditionalAvailabilityCollectionTransferMock);

        $conditionalAvailabilityCollectionTransfer = $this->conditionalAvailabilityReader
            ->findAll();

        $this->assertEquals(
            $conditionalAvailabilityCollectionTransfer,
            $this->conditionalAvailabilityCollectionTransferMock,
        );
    }

    /**
     * @return void
     */
    public function testFindConditionalAvailabilities(): void
    {
        $this->conditionalAvailabilityRepositoryMock->expects($this->atLeastOnce())
            ->method('findConditionalAvailabilities')
            ->with($this->conditionalAvailabilityCriteriaFilterTransferMock)
            ->willReturn($this->conditionalAvailabilityCollectionTransferMock);

        $conditionalAvailabilityCollectionTransfer = $this->conditionalAvailabilityReader
            ->find($this->conditionalAvailabilityCriteriaFilterTransferMock);

        $this->assertEquals(
            $conditionalAvailabilityCollectionTransfer,
            $this->conditionalAvailabilityCollectionTransferMock,
        );
    }
}
