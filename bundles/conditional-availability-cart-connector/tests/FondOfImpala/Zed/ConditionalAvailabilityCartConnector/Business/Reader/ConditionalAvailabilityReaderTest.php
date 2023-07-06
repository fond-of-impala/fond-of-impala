<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reader;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Filter\SkusFilterInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityReaderTest extends Unit
{
    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Filter\SkusFilterInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected SkusFilterInterface|MockObject $skusFilterMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reader\CustomerReaderInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CustomerReaderInterface $customerReaderMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeInterface|MockObject $conditionalAvailabilityFacadeMock;

    /**
     * @var (\Generated\Shared\Transfer\QuoteTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected QuoteTransfer|MockObject $quoteTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\CustomerTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerTransfer|MockObject $customerTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\ConditionalAvailabilityTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityTransfer|MockObject $conditionalAvailabilityTransferMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reader\ConditionalAvailabilityReader
     */
    protected ConditionalAvailabilityReader $conditionalAvailabilityReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->skusFilterMock = $this->getMockBuilder(SkusFilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerReaderMock = $this->getMockBuilder(CustomerReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityFacadeMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityTransferMock = $this->getMockBuilder(ConditionalAvailabilityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityReader = new ConditionalAvailabilityReader(
            $this->skusFilterMock,
            $this->customerReaderMock,
            $this->conditionalAvailabilityFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetGroupedByQuote(): void
    {
        $skus = ['FOO-1'];
        $availabilityChannel = 'BAR';
        $warehouseGroup = 'EU';
        $minimumQuantity = 1;
        $groupedConditionalAvailabilityTransferMocks = new ArrayObject([
            $skus[0] => new ArrayObject([
                $this->conditionalAvailabilityTransferMock,
            ]),
        ]);

        $this->skusFilterMock->expects(static::atLeastOnce())
            ->method('filterFromQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($skus);

        $this->customerReaderMock->expects(static::atLeastOnce())
            ->method('getByQuoteTransfer')
            ->with($this->quoteTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getAvailabilityChannel')
            ->willReturn($availabilityChannel);

        $this->conditionalAvailabilityFacadeMock->expects(static::atLeastOnce())
            ->method('findGroupedConditionalAvailabilities')
            ->with(
                static::callback(
                    static fn (
                        ConditionalAvailabilityCriteriaFilterTransfer $conditionalAvailabilityCriteriaFilterTransfer
                    ): bool => $conditionalAvailabilityCriteriaFilterTransfer->getMinimumQuantity() === $minimumQuantity
                        && $conditionalAvailabilityCriteriaFilterTransfer->getWarehouseGroup() === $warehouseGroup
                        && $conditionalAvailabilityCriteriaFilterTransfer->getSkus() === $skus
                        && $conditionalAvailabilityCriteriaFilterTransfer->getChannel() === $availabilityChannel
                ),
            )->willReturn($groupedConditionalAvailabilityTransferMocks);

        static::assertEquals(
            $groupedConditionalAvailabilityTransferMocks,
            $this->conditionalAvailabilityReader->getGroupedByQuote($this->quoteTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testGetGroupedByQuoteWithoutCustomer(): void
    {
        $skus = ['FOO-1'];

        $this->skusFilterMock->expects(static::atLeastOnce())
            ->method('filterFromQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($skus);

        $this->customerReaderMock->expects(static::atLeastOnce())
            ->method('getByQuoteTransfer')
            ->with($this->quoteTransferMock)
            ->willReturn(null);

        $this->conditionalAvailabilityFacadeMock->expects(static::never())
            ->method('findGroupedConditionalAvailabilities');

        static::assertCount(
            0,
            $this->conditionalAvailabilityReader->getGroupedByQuote($this->quoteTransferMock),
        );
    }
}
