<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Business\Generator;

use Codeception\Test\Unit;
use DateInterval;
use DateTime;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class KeyGeneratorTest extends Unit
{
    protected ConditionalAvailabilityPeriodTransfer|MockObject $conditionalAvailabilityPeriodTransferMock;

    protected KeyGenerator $keyGenerator;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->conditionalAvailabilityPeriodTransferMock = $this->getMockBuilder(ConditionalAvailabilityPeriodTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->keyGenerator = new KeyGenerator();
    }

    /**
     * @return void
     */
    public function testGenerate(): void
    {
        $idConditionalAvailability = 2;

        $startAt = (new DateTime())->add(new DateInterval('P1D'))
            ->format('Y-m-d H:i:s');
        $endAt = (new DateTime())->add(new DateInterval('P11D'))
            ->format('Y-m-d H:i:s');
        $now = new DateTime();

        $keyParts = [
            $idConditionalAvailability,
            $startAt,
            $endAt,
            $now->format('Y-m-d H:i:s'),
        ];

        $key = sha1(implode(':', $keyParts));

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getFkConditionalAvailability')
            ->willReturn($idConditionalAvailability);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn($startAt);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn($endAt);

        static::assertEquals(
            $key,
            $this->keyGenerator->generate(
                $this->conditionalAvailabilityPeriodTransferMock,
                $now,
            ),
        );
    }
}
