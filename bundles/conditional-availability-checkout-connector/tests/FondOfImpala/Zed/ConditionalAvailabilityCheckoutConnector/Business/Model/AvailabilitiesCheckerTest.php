<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Model;

use ArrayObject;
use Codeception\Test\Unit;
use DateTime;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Service\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceInterface;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class AvailabilitiesCheckerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityFacadeInterface
     */
    protected $conditionalAvailabilityFacadeMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Service\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $conditionalAvailabilityServiceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CheckoutResponseTransfer
     */
    protected $checkoutResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ItemTransfer
     */
    protected $itemTransferMock;

    /**
     * @var \ArrayObject<\Generated\Shared\Transfer\ItemTransfer>
     */
    protected $itemTransferMocks;

    /**
     * @var string
     */
    protected $sku;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected $customerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityTransfer
     */
    protected $conditionalAvailabilityTransferMock;

    /**
     * @var \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityTransfer>
     */
    protected $conditionalAvailabilityTransferMocks;

    /**
     * @var string
     */
    protected $concreteDeliveryDate;

    /**
     * @var int
     */
    protected $quantity;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer
     */
    protected $conditionalAvailabilityPeriodCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer
     */
    protected $conditionalAvailabilityPeriodTransferMock;

    /**
     * @var string
     */
    protected $startAt;

    /**
     * @var string
     */
    protected $endAt;

    /**
     * @var \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer>
     */
    protected $conditionalAvailabilityPeriodTransferMocks;

    /**
     * @var int
     */
    protected $availableQuantity;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Model\AvailabilitiesChecker
     */
    protected $availabilitiesChecker;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->conditionalAvailabilityFacadeMock = $this->getMockBuilder(ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityServiceMock = $this->getMockBuilder(ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->checkoutResponseTransferMock = $this->getMockBuilder(CheckoutResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMocks = new ArrayObject([
            $this->itemTransferMock,
        ]);

        $this->sku = 'sku';

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityTransferMock = $this->getMockBuilder(ConditionalAvailabilityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityTransferMocks = new ArrayObject([
            $this->sku => new ArrayObject([
                $this->conditionalAvailabilityTransferMock,
            ]),
        ]);

        $this->concreteDeliveryDate = '2019-07-10 15:06:11.734023';

        $this->availableQuantity = 2;

        $this->conditionalAvailabilityPeriodCollectionTransferMock = $this->getMockBuilder(ConditionalAvailabilityPeriodCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodTransferMock = $this->getMockBuilder(ConditionalAvailabilityPeriodTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodTransferMocks = new ArrayObject([
            $this->conditionalAvailabilityPeriodTransferMock,
        ]);

        $this->startAt = '2019-07-09 15:06:11.734023';

        $this->endAt = '2019-07-11 15:06:11.734023';

        $this->quantity = 1;

        $this->availabilitiesChecker = new AvailabilitiesChecker(
            $this->conditionalAvailabilityFacadeMock,
            $this->conditionalAvailabilityServiceMock,
        );
    }

    /**
     * @return void
     */
    public function testCheck(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn($this->itemTransferMocks);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($this->sku);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getHasAvailabilityRestrictions')
            ->willReturn(false);

        $this->conditionalAvailabilityFacadeMock->expects(static::atLeastOnce())
            ->method('findGroupedConditionalAvailabilities')
            ->willReturn($this->conditionalAvailabilityTransferMocks);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getConcreteDeliveryDate')
            ->willReturn($this->concreteDeliveryDate);

        $this->conditionalAvailabilityServiceMock->expects(static::atLeastOnce())
            ->method('generateLatestOrderDateByDeliveryDate')
            ->willReturn(new DateTime($this->concreteDeliveryDate));

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($this->quantity);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn($this->conditionalAvailabilityPeriodCollectionTransferMock);

        $this->conditionalAvailabilityPeriodCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriods')
            ->willReturn($this->conditionalAvailabilityPeriodTransferMocks);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn($this->startAt);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn($this->endAt);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($this->availableQuantity);

        static::assertTrue(
            $this->availabilitiesChecker->check(
                $this->quoteTransferMock,
                $this->checkoutResponseTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCheckErrorToCheckoutResponse(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn($this->itemTransferMocks);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($this->sku);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getHasAvailabilityRestrictions')
            ->willReturn(false);

        $this->conditionalAvailabilityFacadeMock->expects(static::atLeastOnce())
            ->method('findGroupedConditionalAvailabilities')
            ->willReturn($this->conditionalAvailabilityTransferMocks);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getConcreteDeliveryDate')
            ->willReturn($this->concreteDeliveryDate);

        $this->conditionalAvailabilityServiceMock->expects(static::atLeastOnce())
            ->method('generateLatestOrderDateByDeliveryDate')
            ->willReturn(new DateTime($this->concreteDeliveryDate));

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($this->quantity);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn($this->conditionalAvailabilityPeriodCollectionTransferMock);

        $this->conditionalAvailabilityPeriodCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriods')
            ->willReturn($this->conditionalAvailabilityPeriodTransferMocks);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn($this->startAt);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn($this->endAt);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(0);

        $this->checkoutResponseTransferMock->expects(static::atLeastOnce())
            ->method('addError')
            ->willReturnSelf();

        $this->checkoutResponseTransferMock->expects(static::atLeastOnce())
            ->method('setIsSuccess')
            ->with(false)
            ->willReturnSelf();

        static::assertFalse(
            $this->availabilitiesChecker->check(
                $this->quoteTransferMock,
                $this->checkoutResponseTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCheckErrorToCheckoutResponsesSkuNotExists(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn($this->itemTransferMocks);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($this->sku);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getHasAvailabilityRestrictions')
            ->willReturn(false);

        $this->conditionalAvailabilityFacadeMock->expects(static::atLeastOnce())
            ->method('findGroupedConditionalAvailabilities')
            ->willReturn(new ArrayObject([]));

        $this->checkoutResponseTransferMock->expects(static::atLeastOnce())
            ->method('addError')
            ->willReturnSelf();

        $this->checkoutResponseTransferMock->expects(static::atLeastOnce())
            ->method('setIsSuccess')
            ->with(false)
            ->willReturnSelf();

        static::assertFalse(
            $this->availabilitiesChecker->check(
                $this->quoteTransferMock,
                $this->checkoutResponseTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCheckErrorToCheckoutResponseConditionalAvailabilityPeriodCollectionNull(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn($this->itemTransferMocks);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($this->sku);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getHasAvailabilityRestrictions')
            ->willReturn(false);

        $this->conditionalAvailabilityFacadeMock->expects(static::atLeastOnce())
            ->method('findGroupedConditionalAvailabilities')
            ->willReturn($this->conditionalAvailabilityTransferMocks);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getConcreteDeliveryDate')
            ->willReturn($this->concreteDeliveryDate);

        $this->conditionalAvailabilityServiceMock->expects(static::atLeastOnce())
            ->method('generateLatestOrderDateByDeliveryDate')
            ->willReturn(new DateTime($this->concreteDeliveryDate));

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($this->quantity);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn(null);

        $this->checkoutResponseTransferMock->expects(static::atLeastOnce())
            ->method('addError')
            ->willReturnSelf();

        $this->checkoutResponseTransferMock->expects(static::atLeastOnce())
            ->method('setIsSuccess')
            ->with(false)
            ->willReturnSelf();

        static::assertFalse(
            $this->availabilitiesChecker->check(
                $this->quoteTransferMock,
                $this->checkoutResponseTransferMock,
            ),
        );
    }
}
