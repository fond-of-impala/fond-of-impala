<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Processor\EarliestDeliveryDate\Generator;

use Codeception\Test\Unit;
use DateTime;
use FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Dependency\Service\ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityServiceInterface;
use Generated\Shared\Transfer\RestConditionalAvailabilityPeriodTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class EarliestDeliveryDateGeneratorTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Dependency\Service\ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityServiceInterface
     */
    protected MockObject|ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityServiceInterface $conditionalAvailabilityServiceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestConditionalAvailabilityPeriodTransfer
     */
    protected MockObject|RestConditionalAvailabilityPeriodTransfer $restConditionalAvailabilityPeriodTransferMock;

    /**
     * @var \FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Processor\EarliestDeliveryDate\Generator\EarliestDeliveryDateGenerator
     */
    protected EarliestDeliveryDateGenerator $earliestDeliveryDateGenerator;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->conditionalAvailabilityServiceMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restConditionalAvailabilityPeriodTransferMock = $this->getMockBuilder(RestConditionalAvailabilityPeriodTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->earliestDeliveryDateGenerator = new EarliestDeliveryDateGenerator(
            $this->conditionalAvailabilityServiceMock,
        );
    }

    /**
     * @return void
     */
    public function testGenerateByRestConditionalAvailabilityPeriodTransferWithoutStartAt(): void
    {
        $this->restConditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn(null);

        $this->conditionalAvailabilityServiceMock->expects(static::never())
            ->method('generateEarliestDeliveryDateByDateTime');

        $earliestDeliveryDate = $this->earliestDeliveryDateGenerator->generateByRestConditionalAvailabilityPeriodTransfer(
            $this->restConditionalAvailabilityPeriodTransferMock,
        );

        static::assertEquals(null, $earliestDeliveryDate);
    }

    /**
     * @return void
     */
    public function testGenerateByRestConditionalAvailabilityPeriodTransferWithInvalidDates(): void
    {
        $startAt = (new DateTime())
            ->modify('-2 day')
            ->format('Y-m-d H:i:s');

        $endAt = (new DateTime())
            ->modify('-1 day')
            ->format('Y-m-d H:i:s');

        $this->restConditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn($startAt);

        $this->restConditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn($endAt);

        $this->conditionalAvailabilityServiceMock->expects(static::never())
            ->method('generateEarliestDeliveryDateByDateTime');

        $earliestDeliveryDate = $this->earliestDeliveryDateGenerator->generateByRestConditionalAvailabilityPeriodTransfer(
            $this->restConditionalAvailabilityPeriodTransferMock,
        );

        static::assertEquals(null, $earliestDeliveryDate);
    }

    /**
     * @return void
     */
    public function testGenerateByRestConditionalAvailabilityPeriodTransfer(): void
    {
        $startAt = (new DateTime())
            ->modify('-2 day')
            ->format('Y-m-d H:i:s');

        $endAt = (new DateTime())
            ->modify('+6 day')
            ->format('Y-m-d H:i:s');

        $earliestDeliveryDate = (new DateTime())
            ->setTime(0, 0)
            ->modify('+4 day');

        $this->restConditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn($startAt);

        $this->restConditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn($endAt);

        $this->conditionalAvailabilityServiceMock->expects(static::atLeastOnce())
            ->method('generateEarliestDeliveryDateByDateTime')
            ->with(
                static::callback(
                    static fn (
                        DateTime $earliestAvailabilityDate
                    ): bool => $earliestAvailabilityDate == (new DateTime())->setTime(0, 0),
                ),
            )->willReturn($earliestDeliveryDate);

        static::assertEquals(
            $earliestDeliveryDate,
            $this->earliestDeliveryDateGenerator->generateByRestConditionalAvailabilityPeriodTransfer(
                $this->restConditionalAvailabilityPeriodTransferMock,
            ),
        );
    }
}
