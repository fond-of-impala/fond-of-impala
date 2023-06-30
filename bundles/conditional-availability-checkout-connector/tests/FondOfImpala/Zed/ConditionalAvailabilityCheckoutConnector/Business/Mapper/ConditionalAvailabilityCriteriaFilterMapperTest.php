<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityCriteriaFilterMapperTest extends Unit
{
    protected QuoteTransfer|MockObject $quoteTransferMock;

    protected CustomerTransfer|MockObject $customerTransferMock;

    protected ConditionalAvailabilityCriteriaFilterMapper $conditionalAvailabilityCriteriaFilterMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityCriteriaFilterMapper = new ConditionalAvailabilityCriteriaFilterMapper();
    }

    /**
     * @return void
     */
    public function testFromQuote(): void
    {
        $availabilityChannel = 'FOO';

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCustomer')
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
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn(null);

        static::assertEquals(
            null,
            $this->conditionalAvailabilityCriteriaFilterMapper->fromQuote(
                $this->quoteTransferMock,
            ),
        );
    }
}
