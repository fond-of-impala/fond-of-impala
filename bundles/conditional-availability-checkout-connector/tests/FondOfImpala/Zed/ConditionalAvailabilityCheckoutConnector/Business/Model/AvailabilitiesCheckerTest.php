<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Model;

use ArrayObject;
use Codeception\Test\Unit;
use DateTime;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Service\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceInterface;
use Generated\Shared\Transfer\CheckoutErrorTransfer;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class AvailabilitiesCheckerTest extends Unit
{
    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityFacadeInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacadeMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Service\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceInterface|MockObject $conditionalAvailabilityServiceMock;

    /**
     * @var (\Generated\Shared\Transfer\QuoteTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected QuoteTransfer|MockObject $quoteTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\CheckoutResponseTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CheckoutResponseTransfer|MockObject $checkoutResponseTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\ItemTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ItemTransfer $itemTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\ConditionalAvailabilityTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityTransfer|MockObject $conditionalAvailabilityTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ConditionalAvailabilityPeriodCollectionTransfer $conditionalAvailabilityPeriodCollectionTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityPeriodTransfer|MockObject $conditionalAvailabilityPeriodTransferMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Model\AvailabilitiesChecker
     */
    protected AvailabilitiesChecker $availabilitiesChecker;

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

        $this->conditionalAvailabilityTransferMock = $this->getMockBuilder(ConditionalAvailabilityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodCollectionTransferMock = $this->getMockBuilder(ConditionalAvailabilityPeriodCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodTransferMock = $this->getMockBuilder(ConditionalAvailabilityPeriodTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

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
        $sku = 'sku';
        $warehouseGroup = 'EU';
        $minimumQty = 1;
        $concreteDeliveryDate = '2019-07-10 15:06:11.734023';
        $availableQuantity = 2;
        $startAt = '2019-07-09 15:06:11.734023';
        $endAt = '2019-07-11 15:06:11.734023';
        $quantity = 1;

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn(new ArrayObject([$this->itemTransferMock]));

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($sku);

        $this->conditionalAvailabilityFacadeMock->expects(static::atLeastOnce())
            ->method('findGroupedConditionalAvailabilities')
            ->with(
                static::callback(
                    fn (
                        ConditionalAvailabilityCriteriaFilterTransfer $conditionalAvailabilityCriteriaFilterTransfer
                    ) => $conditionalAvailabilityCriteriaFilterTransfer->getSkus() == [$sku]
                        && $conditionalAvailabilityCriteriaFilterTransfer->getWarehouseGroup() === $warehouseGroup
                        && $conditionalAvailabilityCriteriaFilterTransfer->getMinimumQuantity() === $minimumQty
                ),
            )->willReturn(new ArrayObject([
                $sku => [
                    $this->conditionalAvailabilityTransferMock,
                ],
            ]));

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getConcreteDeliveryDate')
            ->willReturn($concreteDeliveryDate);

        $this->conditionalAvailabilityServiceMock->expects(static::atLeastOnce())
            ->method('generateLatestOrderDateByDeliveryDate')
            ->willReturn(new DateTime($concreteDeliveryDate));

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($quantity);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn($this->conditionalAvailabilityPeriodCollectionTransferMock);

        $this->conditionalAvailabilityPeriodCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriods')
            ->willReturn(new ArrayObject([$this->conditionalAvailabilityPeriodTransferMock]));

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn($startAt);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn($endAt);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($availableQuantity);

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
        $sku = 'sku';
        $warehouseGroup = 'EU';
        $minimumQty = 1;
        $concreteDeliveryDate = '2019-07-10 15:06:11.734023';
        $availableQuantity = 1;
        $startAt = '2019-07-09 15:06:11.734023';
        $endAt = '2019-07-11 15:06:11.734023';
        $quantity = 2;

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn(new ArrayObject([$this->itemTransferMock]));

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($sku);

        $this->conditionalAvailabilityFacadeMock->expects(static::atLeastOnce())
            ->method('findGroupedConditionalAvailabilities')
            ->with(
                static::callback(
                    fn (
                        ConditionalAvailabilityCriteriaFilterTransfer $conditionalAvailabilityCriteriaFilterTransfer
                    ) => $conditionalAvailabilityCriteriaFilterTransfer->getSkus() == [$sku]
                        && $conditionalAvailabilityCriteriaFilterTransfer->getWarehouseGroup() === $warehouseGroup
                        && $conditionalAvailabilityCriteriaFilterTransfer->getMinimumQuantity() === $minimumQty
                ),
            )->willReturn(new ArrayObject([
                $sku => [
                    $this->conditionalAvailabilityTransferMock,
                ],
            ]));

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getConcreteDeliveryDate')
            ->willReturn($concreteDeliveryDate);

        $this->conditionalAvailabilityServiceMock->expects(static::atLeastOnce())
            ->method('generateLatestOrderDateByDeliveryDate')
            ->willReturn(new DateTime($concreteDeliveryDate));

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($quantity);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn($this->conditionalAvailabilityPeriodCollectionTransferMock);

        $this->conditionalAvailabilityPeriodCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriods')
            ->willReturn(new ArrayObject([$this->conditionalAvailabilityPeriodTransferMock]));

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn($startAt);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn($endAt);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($availableQuantity);

        $this->checkoutResponseTransferMock->expects(static::atLeastOnce())
            ->method('addError')
            ->with(
                static::callback(
                    fn (
                        CheckoutErrorTransfer $checkoutErrorTransfer
                    ) => $checkoutErrorTransfer->getErrorCode() === 4102
                        && $checkoutErrorTransfer->getMessage() === 'conditional_availability_checkout_connector.product.unavailable'
                        && $checkoutErrorTransfer->getParameters() == ['%sku%' => $sku]
                        && $checkoutErrorTransfer->getErrorType() === 'Conditional Availability'
                ),
            )->willReturnSelf();

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
        $sku = 'sku';
        $warehouseGroup = 'EU';
        $minimumQty = 1;

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn(new ArrayObject([$this->itemTransferMock]));

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($sku);

        $this->conditionalAvailabilityFacadeMock->expects(static::atLeastOnce())
            ->method('findGroupedConditionalAvailabilities')
            ->with(
                static::callback(
                    fn (
                        ConditionalAvailabilityCriteriaFilterTransfer $conditionalAvailabilityCriteriaFilterTransfer
                    ) => $conditionalAvailabilityCriteriaFilterTransfer->getSkus() == [$sku]
                        && $conditionalAvailabilityCriteriaFilterTransfer->getWarehouseGroup() === $warehouseGroup
                        && $conditionalAvailabilityCriteriaFilterTransfer->getMinimumQuantity() === $minimumQty
                ),
            )->willReturn(new ArrayObject([]));

        $this->checkoutResponseTransferMock->expects(static::atLeastOnce())
            ->method('addError')
            ->with(
                static::callback(
                    fn (
                        CheckoutErrorTransfer $checkoutErrorTransfer
                    ) => $checkoutErrorTransfer->getErrorCode() === 4102
                        && $checkoutErrorTransfer->getMessage() === 'conditional_availability_checkout_connector.product.unavailable'
                        && $checkoutErrorTransfer->getParameters() == ['%sku%' => $sku]
                        && $checkoutErrorTransfer->getErrorType() === 'Conditional Availability'
                ),
            )->willReturnSelf();

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
        $sku = 'sku';
        $warehouseGroup = 'EU';
        $minimumQty = 1;
        $concreteDeliveryDate = '2019-07-10 15:06:11.734023';
        $quantity = 1;

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn(new ArrayObject([$this->itemTransferMock]));

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($sku);

        $this->conditionalAvailabilityFacadeMock->expects(static::atLeastOnce())
            ->method('findGroupedConditionalAvailabilities')
            ->with(
                static::callback(
                    fn (
                        ConditionalAvailabilityCriteriaFilterTransfer $conditionalAvailabilityCriteriaFilterTransfer
                    ) => $conditionalAvailabilityCriteriaFilterTransfer->getSkus() == [$sku]
                        && $conditionalAvailabilityCriteriaFilterTransfer->getWarehouseGroup() === $warehouseGroup
                        && $conditionalAvailabilityCriteriaFilterTransfer->getMinimumQuantity() === $minimumQty
                ),
            )->willReturn(new ArrayObject([
                $sku => [
                    $this->conditionalAvailabilityTransferMock,
                ],
            ]));

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getConcreteDeliveryDate')
            ->willReturn($concreteDeliveryDate);

        $this->conditionalAvailabilityServiceMock->expects(static::atLeastOnce())
            ->method('generateLatestOrderDateByDeliveryDate')
            ->willReturn(new DateTime($concreteDeliveryDate));

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($quantity);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn(null);

        $this->checkoutResponseTransferMock->expects(static::atLeastOnce())
            ->method('addError')
            ->with(
                static::callback(
                    fn (
                        CheckoutErrorTransfer $checkoutErrorTransfer
                    ) => $checkoutErrorTransfer->getErrorCode() === 4102
                        && $checkoutErrorTransfer->getMessage() === 'conditional_availability_checkout_connector.product.unavailable'
                        && $checkoutErrorTransfer->getParameters() == ['%sku%' => $sku]
                        && $checkoutErrorTransfer->getErrorType() === 'Conditional Availability'
                ),
            )->willReturnSelf();

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
