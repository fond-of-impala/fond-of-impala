<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Generator;

use Codeception\Test\Unit;
use DateInterval;
use DateTime;
use DateTimeInterface;
use FondOfImpala\Shared\ConditionalAvailabilityProductPageSearch\ConditionalAvailabilityProductPageSearchConfig;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Exception\InvalidRawValueException;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class StockStatusGeneratorTest extends Unit
{
    /**
     * @var (\Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ConditionalAvailabilityPeriodCollectionTransfer $conditionalAvailabilityPeriodCollectionTransferMock;

    /**
     * @var array<\PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer>
     */
    protected array $conditionalAvailabilityPeriodTransferMocks;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Generator\StockStatusGenerator
     */
    protected StockStatusGenerator $stockStatusGenerator;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->conditionalAvailabilityPeriodCollectionTransferMock = $this->getMockBuilder(
            ConditionalAvailabilityPeriodCollectionTransfer::class,
        )->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodTransferMocks = [
            $this->getMockBuilder(ConditionalAvailabilityPeriodTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(ConditionalAvailabilityPeriodTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(ConditionalAvailabilityPeriodTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->stockStatusGenerator = new StockStatusGenerator();
    }

    /**
     * @return void
     */
    public function testGenerateByConditionalAvailabilityPeriodCollectionWithNowResult(): void
    {
        $this->conditionalAvailabilityPeriodCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriods')
            ->willReturn($this->conditionalAvailabilityPeriodTransferMocks);

        $this->conditionalAvailabilityPeriodTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn(
                (new DateTime())
                    ->sub(new DateInterval('P10D'))
                    ->format(DateTimeInterface::W3C),
            );

        $this->conditionalAvailabilityPeriodTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn(
                (new DateTime())
                    ->format(DateTimeInterface::W3C),
            );

        $this->conditionalAvailabilityPeriodTransferMocks[2]->expects(static::never())
            ->method('getStartAt');

        $this->conditionalAvailabilityPeriodTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn(
                (new DateTime())
                    ->sub(new DateInterval('P1D'))
                    ->format(DateTimeInterface::W3C),
            );

        $this->conditionalAvailabilityPeriodTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn(
                (new DateTime())
                    ->add(new DateInterval('P9D'))
                    ->format(DateTimeInterface::W3C),
            );

        $this->conditionalAvailabilityPeriodTransferMocks[2]->expects(static::never())
            ->method('getEndAt');

        $this->conditionalAvailabilityPeriodTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(10);

        $this->conditionalAvailabilityPeriodTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(15);

        $this->conditionalAvailabilityPeriodTransferMocks[2]->expects(static::never())
            ->method('getQuantity');

        static::assertEquals(
            ConditionalAvailabilityProductPageSearchConfig::STOCK_STATUS_IN_STOCK,
            $this->stockStatusGenerator->generateRawValueByConditionalAvailabilityPeriodCollection(
                $this->conditionalAvailabilityPeriodCollectionTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGenerateByConditionalAvailabilityPeriodCollectionWithLaterResult(): void
    {
        $this->conditionalAvailabilityPeriodCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriods')
            ->willReturn($this->conditionalAvailabilityPeriodTransferMocks);

        $this->conditionalAvailabilityPeriodTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn(
                (new DateTime())
                    ->sub(new DateInterval('P10D'))
                    ->format(DateTimeInterface::W3C),
            );

        $this->conditionalAvailabilityPeriodTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn(
                (new DateTime())
                    ->format(DateTimeInterface::W3C),
            );

        $this->conditionalAvailabilityPeriodTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn(
                (new DateTime())
                    ->add(new DateInterval('P10D'))
                    ->format(DateTimeInterface::W3C),
            );

        $this->conditionalAvailabilityPeriodTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn(
                (new DateTime())
                    ->sub(new DateInterval('P1D'))
                    ->format(DateTimeInterface::W3C),
            );

        $this->conditionalAvailabilityPeriodTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn(
                (new DateTime())
                    ->add(new DateInterval('P9D'))
                    ->format(DateTimeInterface::W3C),
            );

        $this->conditionalAvailabilityPeriodTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn(
                (new DateTime())
                    ->add(new DateInterval('P18D'))
                    ->format(DateTimeInterface::W3C),
            );

        $this->conditionalAvailabilityPeriodTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(0);

        $this->conditionalAvailabilityPeriodTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(0);

        $this->conditionalAvailabilityPeriodTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(10);

        static::assertEquals(
            ConditionalAvailabilityProductPageSearchConfig::STOCK_STATUS_LATER_IN_STOCK,
            $this->stockStatusGenerator->generateRawValueByConditionalAvailabilityPeriodCollection(
                $this->conditionalAvailabilityPeriodCollectionTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGenerateByConditionalAvailabilityPeriodCollection(): void
    {
        $this->conditionalAvailabilityPeriodCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriods')
            ->willReturn($this->conditionalAvailabilityPeriodTransferMocks);

        $this->conditionalAvailabilityPeriodTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn(
                (new DateTime())
                    ->sub(new DateInterval('P10D'))
                    ->format(DateTimeInterface::W3C),
            );

        $this->conditionalAvailabilityPeriodTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn(
                (new DateTime())
                    ->format(DateTimeInterface::W3C),
            );

        $this->conditionalAvailabilityPeriodTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn(
                (new DateTime())
                    ->add(new DateInterval('P10D'))
                    ->format(DateTimeInterface::W3C),
            );

        $this->conditionalAvailabilityPeriodTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn(
                (new DateTime())
                    ->sub(new DateInterval('P1D'))
                    ->format(DateTimeInterface::W3C),
            );

        $this->conditionalAvailabilityPeriodTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn(
                (new DateTime())
                    ->add(new DateInterval('P9D'))
                    ->format(DateTimeInterface::W3C),
            );

        $this->conditionalAvailabilityPeriodTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn(
                (new DateTime())
                    ->add(new DateInterval('P18D'))
                    ->format(DateTimeInterface::W3C),
            );

        $this->conditionalAvailabilityPeriodTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(0);

        $this->conditionalAvailabilityPeriodTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(0);

        $this->conditionalAvailabilityPeriodTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(0);

        static::assertEquals(
            ConditionalAvailabilityProductPageSearchConfig::STOCK_STATUS_OUT_OF_STOCK,
            $this->stockStatusGenerator->generateRawValueByConditionalAvailabilityPeriodCollection(
                $this->conditionalAvailabilityPeriodCollectionTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGenerateByRawValueAndChannel(): void
    {
        $channel = 'foo';

        static::assertEquals(
            sprintf(
                StockStatusGenerator::PATTERN_STOCK_STATUS,
                $channel,
                ConditionalAvailabilityProductPageSearchConfig::STOCK_STATUS_OUT_OF_STOCK,
            ),
            $this->stockStatusGenerator->generateByRawValueAndChannel(
                ConditionalAvailabilityProductPageSearchConfig::STOCK_STATUS_OUT_OF_STOCK,
                $channel,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGenerateByRawValueAndChannelWithError(): void
    {
        $channel = 'foo';

        try {
            $this->stockStatusGenerator->generateByRawValueAndChannel(
                99999,
                $channel,
            );
            static::fail();
        } catch (InvalidRawValueException) {
        }
    }
}
