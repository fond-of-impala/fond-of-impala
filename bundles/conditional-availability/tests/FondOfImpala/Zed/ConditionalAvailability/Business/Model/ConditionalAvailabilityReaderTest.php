<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityRepositoryInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityReaderTest extends Unit
{
    /**
     * @var (\Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityCriteriaFilterTransfer|MockObject $conditionalAvailabilityCriteriaFilterTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ConditionalAvailabilityCollectionTransfer $conditionalAvailabilityCollectionTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\ConditionalAvailabilityTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityTransfer|MockObject $conditionalAvailabilityTransferMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityRepositoryInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ConditionalAvailabilityRepositoryInterface $repositoryMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityReader
     */
    protected ConditionalAvailabilityReader $conditionalAvailabilityReader;

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

        $this->repositoryMock = $this->getMockBuilder(ConditionalAvailabilityRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityReader = new ConditionalAvailabilityReader(
            $this->repositoryMock,
        );
    }

    /**
     * @return void
     */
    public function testFindByIdWithNotExistingDBEntry(): void
    {
        $idConditionalAvailability = 1;

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('requireIdConditionalAvailability')
            ->willReturn($this->conditionalAvailabilityTransferMock);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getIdConditionalAvailability')
            ->willReturn($idConditionalAvailability);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findConditionalAvailabilityById')
            ->with($idConditionalAvailability)
            ->willReturn(null);

        $conditionalAvailabilityResponseTransfer = $this->conditionalAvailabilityReader
            ->findById($this->conditionalAvailabilityTransferMock);

        static::assertFalse($conditionalAvailabilityResponseTransfer->getIsSuccessful());
        static::assertEquals(null, $conditionalAvailabilityResponseTransfer->getConditionalAvailabilityTransfer());
    }

    /**
     * @return void
     */
    public function testFindById(): void
    {
        $idConditionalAvailability = 1;

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('requireIdConditionalAvailability')
            ->willReturn($this->conditionalAvailabilityTransferMock);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getIdConditionalAvailability')
            ->willReturn($idConditionalAvailability);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findConditionalAvailabilityById')
            ->with($idConditionalAvailability)
            ->willReturn($this->conditionalAvailabilityTransferMock);

        $conditionalAvailabilityResponseTransfer = $this->conditionalAvailabilityReader
            ->findById($this->conditionalAvailabilityTransferMock);

        static::assertTrue($conditionalAvailabilityResponseTransfer->getIsSuccessful());
        static::assertEquals(
            $this->conditionalAvailabilityTransferMock,
            $conditionalAvailabilityResponseTransfer->getConditionalAvailabilityTransfer(),
        );
    }

    /**
     * @return void
     */
    public function testFindAll(): void
    {
        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findConditionalAvailabilities')
            ->withAnyParameters()
            ->willReturn($this->conditionalAvailabilityCollectionTransferMock);

        $conditionalAvailabilityCollectionTransfer = $this->conditionalAvailabilityReader
            ->findAll();

        static::assertEquals(
            $conditionalAvailabilityCollectionTransfer,
            $this->conditionalAvailabilityCollectionTransferMock,
        );
    }

    /**
     * @return void
     */
    public function testFindConditionalAvailabilities(): void
    {
        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findConditionalAvailabilities')
            ->with($this->conditionalAvailabilityCriteriaFilterTransferMock)
            ->willReturn($this->conditionalAvailabilityCollectionTransferMock);

        $conditionalAvailabilityCollectionTransfer = $this->conditionalAvailabilityReader
            ->find($this->conditionalAvailabilityCriteriaFilterTransferMock);

        static::assertEquals(
            $conditionalAvailabilityCollectionTransfer,
            $this->conditionalAvailabilityCollectionTransferMock,
        );
    }
}
