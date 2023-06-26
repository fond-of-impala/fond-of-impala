<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityBulkApiMapperTest extends Unit
{
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

        $this->apiDataTransferMock = $this->getMockBuilder(ApiDataTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityBulkApiMapper = new ConditionalAvailabilityBulkApiMapper();
    }

    /**
     * @return void
     */
    public function testMapApiDataTransferToGroupedConditionalAvailabilityTransfers(): void
    {
        $data = [
            ['sku' => 'FOO-1', 'warehouse_group' => 'FOO'],
            ['sku' => 'FOO-2'],
        ];

        $this->apiDataTransferMock->expects(static::atLeastOnce())
            ->method('getData')
            ->willReturn($data);

        $groupedConditionalAvailabilityTransfers = $this->conditionalAvailabilityBulkApiMapper
            ->mapApiDataTransferToGroupedConditionalAvailabilityTransfers(
                $this->apiDataTransferMock,
            );

        static::assertArrayHasKey($data[0]['warehouse_group'], $groupedConditionalAvailabilityTransfers);
        static::assertArrayHasKey(
            $data[0]['sku'],
            $groupedConditionalAvailabilityTransfers[$data[0]['warehouse_group']],
        );
        static::assertInstanceOf(
            ConditionalAvailabilityTransfer::class,
            $groupedConditionalAvailabilityTransfers[$data[0]['warehouse_group']][$data[0]['sku']],
        );
    }
}
