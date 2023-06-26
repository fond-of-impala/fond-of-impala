<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model;

use ArrayObject;
use Codeception\Test\Unit;
use DateTime;
use FondOfImpala\Shared\ConditionalAvailability\ConditionalAvailabilityConstants;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\MessageTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityExpanderTest extends Unit
{
    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeInterface|MockObject $conditionalAvailabilityFacadeMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface|MockObject $conditionalAvailabilityServiceMock;

    /**
     * @var (\Generated\Shared\Transfer\QuoteTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected QuoteTransfer|MockObject $quoteTransferMock;

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
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityExpander
     */
    protected ConditionalAvailabilityExpander $conditionalAvailabilityExpander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->conditionalAvailabilityFacadeMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityServiceMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
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

        $this->conditionalAvailabilityExpander = new ConditionalAvailabilityExpander(
            $this->conditionalAvailabilityFacadeMock,
            $this->conditionalAvailabilityServiceMock,
        );
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $sku = 'foo';
        $warehouseGroup = 'EU';
        $minimumQty = 1;
        $concreteDeliveryDate = (new DateTime())->setTime(0, 0);
        $deliveryDate = $concreteDeliveryDate->format('Y-m-d');
        $qty = 1;
        $startAt = (new DateTime())->format('Y-m-d');
        $endAt = (new DateTime())->modify('+1 day')->format('Y-m-d');

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
            )->willReturn(
                new ArrayObject([
                    $sku => [
                        $this->conditionalAvailabilityTransferMock,
                    ],
                ]),
            );

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn($deliveryDate);

        $this->conditionalAvailabilityServiceMock->expects(static::atLeastOnce())
            ->method('generateLatestOrderDateByDeliveryDate')
            ->with(
                static::callback(
                    fn (DateTime $deliveryDate) => $deliveryDate == $concreteDeliveryDate,
                ),
            )->willReturn($concreteDeliveryDate);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($qty);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn($this->conditionalAvailabilityPeriodCollectionTransferMock);

        $this->conditionalAvailabilityPeriodCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriods')
            ->willReturn(new ArrayObject([
                $this->conditionalAvailabilityPeriodTransferMock,
            ]));

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn($startAt);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn($endAt);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($qty);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDate')
            ->with($deliveryDate)
            ->willReturnSelf();

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('setConcreteDeliveryDate')
            ->with($deliveryDate)
            ->willReturnSelf();

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getConcreteDeliveryDate')
            ->willReturn($deliveryDate);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDates')
            ->with([$deliveryDate])
            ->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setConcreteDeliveryDates')
            ->with([$deliveryDate])
            ->willReturnSelf();

        static::assertEquals(
            $this->quoteTransferMock,
            $this->conditionalAvailabilityExpander->expand($this->quoteTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testExpandEmpty(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn(new ArrayObject([]));

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDates')
            ->with([])
            ->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setConcreteDeliveryDates')
            ->with([])
            ->willReturnSelf();

        static::assertEquals(
            $this->quoteTransferMock,
            $this->conditionalAvailabilityExpander->expand($this->quoteTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testExpandNotAvailableForGivenQyt(): void
    {
        $sku = 'foo';
        $warehouseGroup = 'EU';
        $minimumQty = 1;
        $concreteDeliveryDate = (new DateTime())->setTime(0, 0);
        $deliveryDate = $concreteDeliveryDate->format('Y-m-d');
        $qty = 2;
        $startAt = (new DateTime())->format('Y-m-d');
        $endAt = (new DateTime())->modify('+1 day')->format('Y-m-d');

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn(
                new ArrayObject([$this->itemTransferMock]),
            );

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
            )->willReturn(
                new ArrayObject([
                    $sku => [
                        $this->conditionalAvailabilityTransferMock,
                    ],
                ]),
            );

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn($deliveryDate);

        $this->conditionalAvailabilityServiceMock->expects(static::atLeastOnce())
            ->method('generateLatestOrderDateByDeliveryDate')
            ->with(
                static::callback(
                    fn (DateTime $deliveryDate) => $deliveryDate == $concreteDeliveryDate,
                ),
            )->willReturn($concreteDeliveryDate);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($qty);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn($this->conditionalAvailabilityPeriodCollectionTransferMock);

        $this->conditionalAvailabilityPeriodCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriods')
            ->willReturn(new ArrayObject([
                $this->conditionalAvailabilityPeriodTransferMock,
            ]));

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn($startAt);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn($endAt);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(1);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('addValidationMessage')
            ->with(
                static::callback(
                    fn (MessageTransfer $messageTransfer) => $messageTransfer->getType() === 'error'
                        && $messageTransfer->getValue() === 'conditional_availability_cart_connector.not_available_for_given_qty'
                ),
            )->willReturnSelf();

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getConcreteDeliveryDate')
            ->willReturn($deliveryDate);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDates')
            ->with([$deliveryDate])
            ->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setConcreteDeliveryDates')
            ->with([$deliveryDate])
            ->willReturnSelf();

        static::assertEquals(
            $this->quoteTransferMock,
            $this->conditionalAvailabilityExpander->expand($this->quoteTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testExpandNotAvailableForGivenDate(): void
    {
        $sku = 'foo';
        $warehouseGroup = 'EU';
        $minimumQty = 1;
        $concreteDeliveryDate = (new DateTime())->setTime(0, 0);
        $deliveryDate = $concreteDeliveryDate->format('Y-m-d');
        $qty = 2;

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
            )->willReturn(
                new ArrayObject([
                    $sku => [
                        $this->conditionalAvailabilityTransferMock,
                    ],
                ]),
            );

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn($deliveryDate);

        $this->conditionalAvailabilityServiceMock->expects(static::atLeastOnce())
            ->method('generateLatestOrderDateByDeliveryDate')
            ->with(
                static::callback(
                    fn (DateTime $deliveryDate) => $deliveryDate == $concreteDeliveryDate,
                ),
            )->willReturn($concreteDeliveryDate);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($qty);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn(null);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('addValidationMessage')
            ->with(
                static::callback(
                    fn (MessageTransfer $messageTransfer) => $messageTransfer->getType() === 'error'
                        && $messageTransfer->getValue() === 'conditional_availability_cart_connector.not_available_for_given_delivery_date'
                ),
            )->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDates')
            ->with([$deliveryDate])
            ->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setConcreteDeliveryDates')
            ->with([])
            ->willReturnSelf();

        static::assertEquals(
            $this->quoteTransferMock,
            $this->conditionalAvailabilityExpander->expand($this->quoteTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testExpandNotAvailableForGivenDeliveryDate(): void
    {
        $sku = 'foo';
        $warehouseGroup = 'EU';
        $minimumQty = 1;
        $concreteDeliveryDate = (new DateTime())->setTime(0, 0);
        $deliveryDate = $concreteDeliveryDate->format('Y-m-d');

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

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn($deliveryDate);

        $this->conditionalAvailabilityServiceMock->expects(static::atLeastOnce())
            ->method('generateLatestOrderDateByDeliveryDate')
            ->with(
                static::callback(
                    fn (DateTime $deliveryDate) => $deliveryDate == $concreteDeliveryDate,
                ),
            )->willReturn($concreteDeliveryDate);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('addValidationMessage')
            ->with(
                static::callback(
                    fn (MessageTransfer $messageTransfer) => $messageTransfer->getType() === 'error'
                        && $messageTransfer->getValue() === 'conditional_availability_cart_connector.not_available_for_given_delivery_date'
                ),
            )
            ->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDates')
            ->with([$deliveryDate])
            ->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setConcreteDeliveryDates')
            ->with([])
            ->willReturnSelf();

        static::assertEquals(
            $this->quoteTransferMock,
            $this->conditionalAvailabilityExpander->expand($this->quoteTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testExpandEarliestDate(): void
    {
        $sku = 'foo';
        $warehouseGroup = 'EU';
        $minimumQty = 1;
        $concreteDeliveryDate = (new DateTime())->setTime(0, 0);
        $deliveryDate = $concreteDeliveryDate->format('Y-m-d');
        $qty = 2;
        $startAt = (new DateTime())->format('Y-m-d');
        $endAt = (new DateTime())->modify('+1 day')->format('Y-m-d');

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
            )->willReturn(
                new ArrayObject([
                    $sku => [
                        $this->conditionalAvailabilityTransferMock,
                    ],
                ]),
            );

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn(ConditionalAvailabilityConstants::KEY_EARLIEST_DATE);

        $this->conditionalAvailabilityServiceMock->expects(static::atLeastOnce())
            ->method('generateEarliestDeliveryDate')
            ->willReturn($concreteDeliveryDate);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($qty);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn($this->conditionalAvailabilityPeriodCollectionTransferMock);

        $this->conditionalAvailabilityPeriodCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriods')
            ->willReturn(new ArrayObject([
                $this->conditionalAvailabilityPeriodTransferMock,
            ]));

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn($startAt);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn($endAt);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($qty);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDate')
            ->with(ConditionalAvailabilityConstants::KEY_EARLIEST_DATE)
            ->willReturnSelf();

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('setConcreteDeliveryDate')
            ->with($deliveryDate)
            ->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDates')
            ->with([ConditionalAvailabilityConstants::KEY_EARLIEST_DATE])
            ->willReturnSelf();

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getConcreteDeliveryDate')
            ->willReturn($deliveryDate);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setConcreteDeliveryDates')
            ->with([$deliveryDate])
            ->willReturnSelf();

        static::assertEquals(
            $this->quoteTransferMock,
            $this->conditionalAvailabilityExpander->expand($this->quoteTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testExpandEarliestDeliveryNotAvailableForGivenQyt(): void
    {
        $sku = 'foo';
        $warehouseGroup = 'EU';
        $minimumQty = 1;
        $concreteDeliveryDate = (new DateTime())->setTime(0, 0);
        $qty = 2;
        $startAt = (new DateTime())->format('Y-m-d');
        $endAt = (new DateTime())->modify('+1 day')->format('Y-m-d');

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
            )->willReturn(
                new ArrayObject([
                    $sku => [
                        $this->conditionalAvailabilityTransferMock,
                    ],
                ]),
            );

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn(ConditionalAvailabilityConstants::KEY_EARLIEST_DATE);

        $this->conditionalAvailabilityServiceMock->expects(static::atLeastOnce())
            ->method('generateEarliestDeliveryDate')
            ->willReturn($concreteDeliveryDate);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($qty);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn($this->conditionalAvailabilityPeriodCollectionTransferMock);

        $this->conditionalAvailabilityPeriodCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriods')
            ->willReturn(new ArrayObject([
                $this->conditionalAvailabilityPeriodTransferMock,
            ]));

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn($startAt);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn($endAt);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($qty - 1);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('addValidationMessage')
            ->with(
                static::callback(
                    fn (MessageTransfer $messageTransfer) => $messageTransfer->getType() === 'error'
                        && $messageTransfer->getValue() === 'conditional_availability_cart_connector.not_available_for_given_qty'
                ),
            )
            ->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDates')
            ->with([ConditionalAvailabilityConstants::KEY_EARLIEST_DATE])
            ->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setConcreteDeliveryDates')
            ->with([])
            ->willReturnSelf();

        static::assertEquals(
            $this->quoteTransferMock,
            $this->conditionalAvailabilityExpander->expand($this->quoteTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testExpandEarliestDeliveryNotAvailableForGivenDeliveryDate(): void
    {
        $sku = 'foo';
        $warehouseGroup = 'EU';
        $minimumQty = 1;
        $concreteDeliveryDate = (new DateTime())->setTime(0, 0);

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
            )->willReturn(
                new ArrayObject([]),
            );

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('addValidationMessage')
            ->with(
                static::callback(
                    fn (MessageTransfer $messageTransfer) => $messageTransfer->getType() === 'error'
                        && $messageTransfer->getValue() === 'conditional_availability_cart_connector.not_available_for_earliest_delivery_date'
                ),
            )->willReturnSelf();

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn(ConditionalAvailabilityConstants::KEY_EARLIEST_DATE);

        $this->conditionalAvailabilityServiceMock->expects(static::atLeastOnce())
            ->method('generateEarliestDeliveryDate')
            ->willReturn($concreteDeliveryDate);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDates')
            ->with([ConditionalAvailabilityConstants::KEY_EARLIEST_DATE])
            ->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setConcreteDeliveryDates')
            ->with([])
            ->willReturnSelf();

        static::assertEquals(
            $this->quoteTransferMock,
            $this->conditionalAvailabilityExpander->expand($this->quoteTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testExpandEarliestDeliveryNotAvailableForEarliestDeliveryDate(): void
    {
        $sku = 'foo';
        $warehouseGroup = 'EU';
        $minimumQty = 1;
        $concreteDeliveryDate = (new DateTime())->setTime(0, 0);
        $qty = 2;

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
            )->willReturn(
                new ArrayObject([
                    $sku => [
                        $this->conditionalAvailabilityTransferMock,
                    ],
                ]),
            );

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn(ConditionalAvailabilityConstants::KEY_EARLIEST_DATE);

        $this->conditionalAvailabilityServiceMock->expects(static::atLeastOnce())
            ->method('generateEarliestDeliveryDate')
            ->willReturn($concreteDeliveryDate);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($qty);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn(null);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('addValidationMessage')
            ->with(
                static::callback(
                    fn (MessageTransfer $messageTransfer) => $messageTransfer->getType() === 'error'
                        && $messageTransfer->getValue() === 'conditional_availability_cart_connector.not_available_for_earliest_delivery_date'
                ),
            )->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDates')
            ->with([ConditionalAvailabilityConstants::KEY_EARLIEST_DATE])
            ->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setConcreteDeliveryDates')
            ->with([])
            ->willReturnSelf();

        static::assertEquals(
            $this->quoteTransferMock,
            $this->conditionalAvailabilityExpander->expand($this->quoteTransferMock),
        );
    }
}
