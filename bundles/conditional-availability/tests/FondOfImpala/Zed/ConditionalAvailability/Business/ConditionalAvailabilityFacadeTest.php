<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Business;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityPeriodsPersister;
use FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityReader;
use FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityWriter;
use FondOfImpala\Zed\ConditionalAvailability\Business\Model\GroupedConditionalAvailabilityReader;
use FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityRepository;
use Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;

class ConditionalAvailabilityFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailability\Business\ConditionalAvailabilityFacade
     */
    protected $conditionalAvailabilityFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailability\Business\ConditionalAvailabilityBusinessFactory
     */
    protected $conditionalAvailabilityBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailability\Business\Model\GroupedConditionalAvailabilityReader
     */
    protected $groupedConditionalAvailabilityReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityReader
     */
    protected $conditionalAvailabilityReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityWriter
     */
    protected $conditionalAvailabilityWriterMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityPeriodsPersister
     */
    protected $conditionalAvailabilityPeriodsPersisterMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityTransfer
     */
    protected $conditionalAvailabilityTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer
     */
    protected $conditionalAvailabilityResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer
     */
    protected $conditionalAvailabilityCriteriaFilterTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\ArrayObject
     */
    protected $arrayObjectMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer
     */
    protected $conditionalAvailabilityCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityRepository
     */
    protected $conditionalAvailabilityRepositoryMock;

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

        $this->groupedConditionalAvailabilityReaderMock = $this->getMockBuilder(GroupedConditionalAvailabilityReader::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityReaderMock = $this->getMockBuilder(ConditionalAvailabilityReader::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityWriterMock = $this->getMockBuilder(ConditionalAvailabilityWriter::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodsPersisterMock = $this->getMockBuilder(ConditionalAvailabilityPeriodsPersister::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityBusinessFactoryMock = $this->getMockBuilder(ConditionalAvailabilityBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityRepositoryMock = $this->getMockBuilder(ConditionalAvailabilityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityFacade = new ConditionalAvailabilityFacade();
        $this->conditionalAvailabilityFacade->setFactory($this->conditionalAvailabilityBusinessFactoryMock);
        $this->conditionalAvailabilityFacade->setRepository($this->conditionalAvailabilityRepositoryMock);
    }

    /**
     * @return void
     */
    public function testFindConditionalAvailabilityById(): void
    {
        $this->conditionalAvailabilityBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createConditionalAvailabilityReader')
            ->willReturn($this->conditionalAvailabilityReaderMock);

        $this->conditionalAvailabilityReaderMock->expects($this->atLeastOnce())
            ->method('findById')
            ->with($this->conditionalAvailabilityTransferMock)
            ->willReturn($this->conditionalAvailabilityResponseTransferMock);

        $this->assertEquals(
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
        $this->conditionalAvailabilityBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createConditionalAvailabilityWriter')
            ->willReturn($this->conditionalAvailabilityWriterMock);

        $this->conditionalAvailabilityWriterMock->expects($this->atLeastOnce())
            ->method('create')
            ->with($this->conditionalAvailabilityTransferMock)
            ->willReturn($this->conditionalAvailabilityResponseTransferMock);

        $this->assertEquals(
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
        $this->conditionalAvailabilityBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createConditionalAvailabilityWriter')
            ->willReturn($this->conditionalAvailabilityWriterMock);

        $this->conditionalAvailabilityWriterMock->expects($this->atLeastOnce())
            ->method('update')
            ->with($this->conditionalAvailabilityTransferMock)
            ->willReturn($this->conditionalAvailabilityResponseTransferMock);

        $this->assertEquals(
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
        $this->conditionalAvailabilityBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createConditionalAvailabilityWriter')
            ->willReturn($this->conditionalAvailabilityWriterMock);

        $this->conditionalAvailabilityWriterMock->expects($this->atLeastOnce())
            ->method('persist')
            ->with($this->conditionalAvailabilityTransferMock)
            ->willReturn($this->conditionalAvailabilityResponseTransferMock);

        $this->assertEquals(
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
        $this->conditionalAvailabilityBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createConditionalAvailabilityWriter')
            ->willReturn($this->conditionalAvailabilityWriterMock);

        $this->conditionalAvailabilityWriterMock->expects($this->atLeastOnce())
            ->method('delete')
            ->with($this->conditionalAvailabilityTransferMock)
            ->willReturn($this->conditionalAvailabilityResponseTransferMock);

        $this->assertEquals(
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
        $this->conditionalAvailabilityBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createConditionalAvailabilityPeriodsPersister')
            ->willReturn($this->conditionalAvailabilityPeriodsPersisterMock);

        $this->conditionalAvailabilityPeriodsPersisterMock->expects($this->atLeastOnce())
            ->method('persist')
            ->with($this->conditionalAvailabilityTransferMock)
            ->willReturn($this->conditionalAvailabilityTransferMock);

        $this->assertEquals(
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
        $this->conditionalAvailabilityBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createGroupedConditionalAvailabilityReader')
            ->willReturn($this->groupedConditionalAvailabilityReaderMock);

        $this->groupedConditionalAvailabilityReaderMock->expects($this->atLeastOnce())
            ->method('find')
            ->with($this->conditionalAvailabilityCriteriaFilterTransferMock)
            ->willReturn($this->arrayObjectMock);

        $this->assertEquals(
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
        $this->conditionalAvailabilityBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createConditionalAvailabilityReader')
            ->willReturn($this->conditionalAvailabilityReaderMock);

        $this->conditionalAvailabilityReaderMock->expects($this->atLeastOnce())
            ->method('find')
            ->with($this->conditionalAvailabilityCriteriaFilterTransferMock)
            ->willReturn($this->conditionalAvailabilityCollectionTransferMock);

        $this->assertEquals(
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

        $this->conditionalAvailabilityRepositoryMock->expects($this->atLeastOnce())
            ->method('getConditionalAvailabilityIdsByProductConcreteIds')
            ->with($productConcreteIds)
            ->willReturn($conditionalAvailabilityIds);

        $this->assertEquals(
            $conditionalAvailabilityIds,
            $this->conditionalAvailabilityFacade->getConditionalAvailabilityIdsByProductConcreteIds($productConcreteIds),
        );
    }
}
