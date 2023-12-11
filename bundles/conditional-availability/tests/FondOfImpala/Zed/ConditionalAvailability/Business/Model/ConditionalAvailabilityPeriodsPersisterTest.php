<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailability\Business\Generator\KeyGeneratorInterface;
use FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityEntityManagerInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityPeriodsPersisterTest extends Unit
{
    protected MockObject|ConditionalAvailabilityEntityManagerInterface $conditionalAvailabilityEntityManagerMock;

    protected MockObject|KeyGeneratorInterface $keyGeneratorMock;

    protected MockObject|ConditionalAvailabilityTransfer $conditionalAvailabilityTransferMock;

    protected MockObject|ConditionalAvailabilityPeriodCollectionTransfer $conditionalAvailabilityPeriodCollectionTransferMock;

    /**
     * @var array<\Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer>|array<\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $conditionalAvailabilityPeriodTransferMocks;

    protected ConditionalAvailabilityPeriodsPersister $conditionalAvailabilityPeriodsPersister;

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

        $this->keyGeneratorMock = $this->getMockBuilder(KeyGeneratorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityEntityManagerMock = $this->getMockBuilder(ConditionalAvailabilityEntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodsPersister = new ConditionalAvailabilityPeriodsPersister(
            $this->keyGeneratorMock,
            $this->conditionalAvailabilityEntityManagerMock,
        );
    }

    /**
     * @return void
     */
    public function testPersistWithInvalidConditionalAvailabilityTransfer(): void
    {
        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getIdConditionalAvailability')
            ->willReturn(null);

        static::assertEquals(
            $this->conditionalAvailabilityTransferMock,
            $this->conditionalAvailabilityPeriodsPersister->persist($this->conditionalAvailabilityTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testPersistWithoutConditionalAvailabilityPeriodCollection(): void
    {
        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getIdConditionalAvailability')
            ->willReturn(1);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn(null);

        static::assertEquals(
            $this->conditionalAvailabilityTransferMock,
            $this->conditionalAvailabilityPeriodsPersister->persist($this->conditionalAvailabilityTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testPersist(): void
    {
        $key = sha1('foo');
        $idConditionalAvailability = 1;

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getIdConditionalAvailability')
            ->willReturn($idConditionalAvailability);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn($this->conditionalAvailabilityPeriodCollectionTransferMock);

        $this->conditionalAvailabilityEntityManagerMock->expects(static::atLeastOnce())
            ->method('deleteConditionalAvailabilityPeriodsByConditionalAvailabilityId')
            ->with($idConditionalAvailability);

        $this->conditionalAvailabilityPeriodCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriods')
            ->willReturn($this->conditionalAvailabilityPeriodTransferMocks);

        $this->keyGeneratorMock->expects(static::atLeastOnce())
            ->method('generate')
            ->with($this->conditionalAvailabilityPeriodTransferMocks[0], static::callback(static fn (): bool => true))
            ->willReturn($key);

        $this->conditionalAvailabilityPeriodTransferMocks[0]->expects(static::atLeastOnce())
            ->method('setFkConditionalAvailability')
            ->with($idConditionalAvailability)
            ->willReturn($this->conditionalAvailabilityPeriodTransferMocks[0]);

        $this->conditionalAvailabilityPeriodTransferMocks[0]->expects(static::atLeastOnce())
            ->method('setCreatedAt')
            ->with(
                static::callback(
                    static fn (string $createdAt): bool => true,
                ),
            )->willReturn($this->conditionalAvailabilityPeriodTransferMocks[0]);

        $this->conditionalAvailabilityPeriodTransferMocks[0]->expects(static::atLeastOnce())
            ->method('setKey')
            ->with($key)
            ->willReturn($this->conditionalAvailabilityPeriodTransferMocks[0]);

        $this->conditionalAvailabilityEntityManagerMock->expects(static::atLeastOnce())
            ->method('createConditionalAvailabilityPeriod')
            ->with($this->conditionalAvailabilityPeriodTransferMocks[0]);

        static::assertEquals(
            $this->conditionalAvailabilityTransferMock,
            $this->conditionalAvailabilityPeriodsPersister->persist($this->conditionalAvailabilityTransferMock),
        );
    }
}
