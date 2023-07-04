<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Mapper;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Reader\CustomerReaderInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityCriteriaFilterMapperTest extends Unit
{
    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Reader\CustomerReaderInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerReaderInterface|MockObject $customerReaderMock;

    /**
     * @var (\Generated\Shared\Transfer\QuoteTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected QuoteTransfer|MockObject $quoteTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\CustomerTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerTransfer|MockObject $customerTransferMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Mapper\ConditionalAvailabilityCriteriaFilterMapper
     */
    protected ConditionalAvailabilityCriteriaFilterMapper $conditionalAvailabilityCriteriaFilterMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->customerReaderMock = $this->getMockBuilder(CustomerReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityCriteriaFilterMapper = new ConditionalAvailabilityCriteriaFilterMapper(
            $this->customerReaderMock,
        );
    }

    /**
     * @return void
     */
    public function testFromQuote(): void
    {
        $availabilityChannel = 'FOO';

        $this->customerReaderMock->expects(static::atLeastOnce())
            ->method('getByQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getAvailabilityChannel')
            ->willReturn($availabilityChannel);

        $conditionalAvailabilityCriteriaFilter = $this->conditionalAvailabilityCriteriaFilterMapper->fromQuote(
            $this->quoteTransferMock,
        );

        static::assertEquals($availabilityChannel, $conditionalAvailabilityCriteriaFilter->getChannel());
        static::assertEquals('EU', $conditionalAvailabilityCriteriaFilter->getWarehouseGroup());
        static::assertEquals(1, $conditionalAvailabilityCriteriaFilter->getMinimumQuantity());
    }

    /**
     * @return void
     */
    public function testFromQuoteWithoutCustomer(): void
    {
        $this->customerReaderMock->expects(static::atLeastOnce())
            ->method('getByQuote')
            ->with($this->quoteTransferMock)
            ->willReturn(null);

        static::assertEquals(
            null,
            $this->conditionalAvailabilityCriteriaFilterMapper->fromQuote(
                $this->quoteTransferMock,
            ),
        );
    }
}
