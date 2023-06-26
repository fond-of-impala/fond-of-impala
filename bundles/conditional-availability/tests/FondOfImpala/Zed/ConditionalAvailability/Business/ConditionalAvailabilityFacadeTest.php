<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Business;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityPeriodsPersisterInterface;
use FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityReaderInterface;
use FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityWriterInterface;
use FondOfImpala\Zed\ConditionalAvailability\Business\Model\GroupedConditionalAvailabilityReaderInterface;
use FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityRepository;
use Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityFacadeTest extends Unit
{
    /**
     * @var (\Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ConditionalAvailabilityCollectionTransfer $conditionalAvailabilityCollectionTransferMock;

    /**
     * @var (\ArrayObject&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ArrayObject|MockObject $arrayObjectMock;

    /**
     * @var (\Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityCriteriaFilterTransfer|MockObject $conditionalAvailabilityCriteriaFilterTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ConditionalAvailabilityResponseTransfer $conditionalAvailabilityResponseTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\ConditionalAvailabilityTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityTransfer|MockObject $conditionalAvailabilityTransferMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailability\Business\Model\GroupedConditionalAvailabilityReaderInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|GroupedConditionalAvailabilityReaderInterface $groupedConditionalAvailabilityReaderMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityReaderInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ConditionalAvailabilityReaderInterface $conditionalAvailabilityReaderMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityWriterInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ConditionalAvailabilityWriterInterface $conditionalAvailabilityWriterMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityPeriodsPersisterInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ConditionalAvailabilityPeriodsPersisterInterface $conditionalAvailabilityPeriodsPersisterMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailability\Business\ConditionalAvailabilityBusinessFactory&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ConditionalAvailabilityBusinessFactory $factoryMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityRepository&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ConditionalAvailabilityRepository $repositoryMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailability\Business\ConditionalAvailabilityFacade
     */
    protected ConditionalAvailabilityFacade $conditionalAvailabilityFacade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->conditionalAvailabilityCollectionTransferMock = $this->getMockBuilder(ConditionalAvailabilityCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->arrayObjectMock = $this->getMockBuilder(ArrayObject::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityCriteriaFilterTransferMock = $this->getMockBuilder(ConditionalAvailabilityCriteriaFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityResponseTransferMock = $this->getMockBuilder(ConditionalAvailabilityResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityTransferMock = $this->getMockBuilder(ConditionalAvailabilityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->groupedConditionalAvailabilityReaderMock = $this->getMockBuilder(GroupedConditionalAvailabilityReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityReaderMock = $this->getMockBuilder(ConditionalAvailabilityReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityWriterMock = $this->getMockBuilder(ConditionalAvailabilityWriterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodsPersisterMock = $this->getMockBuilder(ConditionalAvailabilityPeriodsPersisterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this->getMockBuilder(ConditionalAvailabilityBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(ConditionalAvailabilityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityFacade = new ConditionalAvailabilityFacade();
        $this->conditionalAvailabilityFacade->setFactory($this->factoryMock);
        $this->conditionalAvailabilityFacade->setRepository($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testFindConditionalAvailabilityById(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createConditionalAvailabilityReader')
            ->willReturn($this->conditionalAvailabilityReaderMock);

        $this->conditionalAvailabilityReaderMock->expects(static::atLeastOnce())
            ->method('findById')
            ->with($this->conditionalAvailabilityTransferMock)
            ->willReturn($this->conditionalAvailabilityResponseTransferMock);

        static::assertEquals(
            $this->conditionalAvailabilityResponseTransferMock,
            $this->conditionalAvailabilityFacade->findConditionalAvailabilityById(
                $this->conditionalAvailabilityTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCreateConditionalAvailability(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createConditionalAvailabilityWriter')
            ->willReturn($this->conditionalAvailabilityWriterMock);

        $this->conditionalAvailabilityWriterMock->expects(static::atLeastOnce())
            ->method('create')
            ->with($this->conditionalAvailabilityTransferMock)
            ->willReturn($this->conditionalAvailabilityResponseTransferMock);

        static::assertEquals(
            $this->conditionalAvailabilityResponseTransferMock,
            $this->conditionalAvailabilityFacade->createConditionalAvailability(
                $this->conditionalAvailabilityTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testUpdateConditionalAvailability(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createConditionalAvailabilityWriter')
            ->willReturn($this->conditionalAvailabilityWriterMock);

        $this->conditionalAvailabilityWriterMock->expects(static::atLeastOnce())
            ->method('update')
            ->with($this->conditionalAvailabilityTransferMock)
            ->willReturn($this->conditionalAvailabilityResponseTransferMock);

        static::assertEquals(
            $this->conditionalAvailabilityResponseTransferMock,
            $this->conditionalAvailabilityFacade->updateConditionalAvailability(
                $this->conditionalAvailabilityTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testPersistConditionalAvailability(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createConditionalAvailabilityWriter')
            ->willReturn($this->conditionalAvailabilityWriterMock);

        $this->conditionalAvailabilityWriterMock->expects(static::atLeastOnce())
            ->method('persist')
            ->with($this->conditionalAvailabilityTransferMock)
            ->willReturn($this->conditionalAvailabilityResponseTransferMock);

        static::assertEquals(
            $this->conditionalAvailabilityResponseTransferMock,
            $this->conditionalAvailabilityFacade->persistConditionalAvailability(
                $this->conditionalAvailabilityTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testDeleteConditionalAvailability(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createConditionalAvailabilityWriter')
            ->willReturn($this->conditionalAvailabilityWriterMock);

        $this->conditionalAvailabilityWriterMock->expects(static::atLeastOnce())
            ->method('delete')
            ->with($this->conditionalAvailabilityTransferMock)
            ->willReturn($this->conditionalAvailabilityResponseTransferMock);

        static::assertEquals(
            $this->conditionalAvailabilityResponseTransferMock,
            $this->conditionalAvailabilityFacade->deleteConditionalAvailability(
                $this->conditionalAvailabilityTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testPersistConditionalAvailabilityPeriods(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createConditionalAvailabilityPeriodsPersister')
            ->willReturn($this->conditionalAvailabilityPeriodsPersisterMock);

        $this->conditionalAvailabilityPeriodsPersisterMock->expects(static::atLeastOnce())
            ->method('persist')
            ->with($this->conditionalAvailabilityTransferMock)
            ->willReturn($this->conditionalAvailabilityTransferMock);

        static::assertEquals(
            $this->conditionalAvailabilityTransferMock,
            $this->conditionalAvailabilityFacade->persistConditionalAvailabilityPeriods(
                $this->conditionalAvailabilityTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testFindGroupedConditionalAvailabilities(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createGroupedConditionalAvailabilityReader')
            ->willReturn($this->groupedConditionalAvailabilityReaderMock);

        $this->groupedConditionalAvailabilityReaderMock->expects(static::atLeastOnce())
            ->method('find')
            ->with($this->conditionalAvailabilityCriteriaFilterTransferMock)
            ->willReturn($this->arrayObjectMock);

        static::assertEquals(
            $this->arrayObjectMock,
            $this->conditionalAvailabilityFacade->findGroupedConditionalAvailabilities(
                $this->conditionalAvailabilityCriteriaFilterTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testFindConditionalAvailabilities(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createConditionalAvailabilityReader')
            ->willReturn($this->conditionalAvailabilityReaderMock);

        $this->conditionalAvailabilityReaderMock->expects(static::atLeastOnce())
            ->method('find')
            ->with($this->conditionalAvailabilityCriteriaFilterTransferMock)
            ->willReturn($this->conditionalAvailabilityCollectionTransferMock);

        static::assertEquals(
            $this->conditionalAvailabilityCollectionTransferMock,
            $this->conditionalAvailabilityFacade->findConditionalAvailabilities(
                $this->conditionalAvailabilityCriteriaFilterTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetConditionalAvailabilityIdsByProductConcreteIds(): void
    {
        $conditionalAvailabilityIds = [1, 2, 3];
        $productConcreteIds = [1];

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityIdsByProductConcreteIds')
            ->with($productConcreteIds)
            ->willReturn($conditionalAvailabilityIds);

        static::assertEquals(
            $conditionalAvailabilityIds,
            $this->conditionalAvailabilityFacade->getConditionalAvailabilityIdsByProductConcreteIds($productConcreteIds),
        );
    }
}
