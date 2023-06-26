<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Business\Model;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityRepositoryInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;

class GroupedConditionalAvailabilityReaderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailability\Business\Model\GroupedConditionalAvailabilityReader
     */
    protected $groupedConditionalAvailabilityReader;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityRepositoryInterface
     */
    protected $conditionalAvailabilityRepositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer
     */
    protected $conditionalAvailabilityCriteriaFilterTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\ArrayObject
     */
    protected $arrayObjectMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->conditionalAvailabilityCriteriaFilterTransferMock = $this->getMockBuilder(ConditionalAvailabilityCriteriaFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->arrayObjectMock = $this->getMockBuilder(ArrayObject::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityRepositoryMock = $this->getMockBuilder(ConditionalAvailabilityRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->groupedConditionalAvailabilityReader = new GroupedConditionalAvailabilityReader(
            $this->conditionalAvailabilityRepositoryMock,
        );
    }

    /**
     * @return void
     */
    public function testFind(): void
    {
        $this->conditionalAvailabilityRepositoryMock->expects(static::atLeastOnce())
            ->method('findGroupedConditionalAvailabilities')
            ->with($this->conditionalAvailabilityCriteriaFilterTransferMock)
            ->willReturn($this->arrayObjectMock);

        static::assertEquals(
            $this->arrayObjectMock,
            $this->groupedConditionalAvailabilityReader->find($this->conditionalAvailabilityCriteriaFilterTransferMock),
        );
    }
}
