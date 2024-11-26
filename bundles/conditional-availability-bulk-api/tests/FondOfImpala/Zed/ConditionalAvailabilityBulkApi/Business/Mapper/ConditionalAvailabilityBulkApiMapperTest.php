<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Mapper;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Generator\GroupKeyGeneratorInterface;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityBulkApiMapperTest extends Unit
{
    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Generator\GroupKeyGeneratorInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|GroupKeyGeneratorInterface $groupKeyGeneratorMock;

    /**
     * @var (\Generated\Shared\Transfer\ApiDataTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ApiDataTransfer|MockObject $apiDataTransferMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Mapper\ConditionalAvailabilityBulkApiMapper
     */
    protected ConditionalAvailabilityBulkApiMapper $conditionalAvailabilityBulkApiMapper;

    /**
     * @Override
     *
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->groupKeyGeneratorMock = $this->getMockBuilder(GroupKeyGeneratorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiDataTransferMock = $this->getMockBuilder(ApiDataTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityBulkApiMapper = new ConditionalAvailabilityBulkApiMapper(
            $this->groupKeyGeneratorMock,
        );
    }

    /**
     * @return void
     */
    public function testMapApiDataTransferToGroupedConditionalAvailabilityTransfers(): void
    {
        $self = $this;
        $data = [
            ['sku' => 'FOO-1', 'warehouse_group' => 'FOO'],
            ['sku' => 'FOO-2'],
        ];

        $groupKey = sha1($data[0]['warehouse_group']);

        $this->apiDataTransferMock->expects(static::atLeastOnce())
            ->method('getData')
            ->willReturn($data);

        $callCount = $this->atLeastOnce();
        $this->groupKeyGeneratorMock->expects($callCount)
            ->method('generateByApiData')
            ->willReturnCallback(static function (array $array) use ($self, $callCount, $data, $groupKey) {
                /** @phpstan-ignore-next-line */
                if (method_exists($callCount, 'getInvocationCount')) {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount->getInvocationCount();
                } else {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount->numberOfInvocations();
                }

                switch ($count) {
                    case 1:
                        $self->assertSame($array, $data[0]);

                        return $groupKey;
                    case 2:
                        $self->assertSame($array, $data[1]);

                        return null;
                }

                throw new Exception('Unexpected call count');
            });

        $groupedConditionalAvailabilityTransfers = $this->conditionalAvailabilityBulkApiMapper
            ->mapApiDataTransferToGroupedConditionalAvailabilityTransfers(
                $this->apiDataTransferMock,
            );

        static::assertEquals([$groupKey], array_keys($groupedConditionalAvailabilityTransfers));
        static::assertEquals(
            [$data[0]['sku']],
            array_keys($groupedConditionalAvailabilityTransfers[$groupKey]),
        );
        static::assertInstanceOf(
            ConditionalAvailabilityTransfer::class,
            $groupedConditionalAvailabilityTransfers[$groupKey][$data[0]['sku']],
        );
    }
}
