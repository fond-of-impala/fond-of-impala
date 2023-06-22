<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Processor\ConditionalAvailabilityPageSearch\Mapper;

use Codeception\Test\Unit;
use FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApiExtension\Dependency\Plugin\RestConditionalAvailabilityPeriodMapperPluginInterface;
use Generated\Shared\Transfer\RestConditionalAvailabilityPeriodTransfer;

class ConditionalAvailabilityPageSearchMapperTest extends Unit
{
    /**
     * @var array
     */
    protected $searchResult;

    /**
     * @var array<\PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApiExtension\Dependency\Plugin\RestConditionalAvailabilityPeriodMapperPluginInterface>
     */
    protected $restConditionalAvailabilityPeriodMapperPluginMocks;

    /**
     * @var \FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Processor\ConditionalAvailabilityPageSearch\Mapper\ConditionalAvailabilityPageSearchMapper
     */
    protected $conditionalAvailabilityPageSearchMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->searchResult = [
            'periods' => [
                [
                    'quantity' => 12,
                    'sku' => 'FOO-BAR-001-001',
                    'warehouseGroup' => 'EU',
                ],
            ],
        ];

        $this->restConditionalAvailabilityPeriodMapperPluginMocks = [
            $this->getMockBuilder(RestConditionalAvailabilityPeriodMapperPluginInterface::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->conditionalAvailabilityPageSearchMapper = new ConditionalAvailabilityPageSearchMapper(
            $this->restConditionalAvailabilityPeriodMapperPluginMocks,
        );
    }

    /**
     * @return void
     */
    public function testMapSearchResultToRestConditionalAvailabilityPageSearchCollectionResponseTransfer(): void
    {
        $self = $this;

        $this->restConditionalAvailabilityPeriodMapperPluginMocks[0]->expects(static::atLeastOnce())
            ->method('mapPeriodDataToRestConditionalAvailabilityPeriodTransfer')
            ->with(
                $this->searchResult['periods'][0],
                static::callback(
                    static function (
                        RestConditionalAvailabilityPeriodTransfer $restConditionalAvailabilityPeriodTransfer
                    ) use ($self) {
                        return $restConditionalAvailabilityPeriodTransfer->getSku() === $self->searchResult['periods'][0]['sku']
                            && $restConditionalAvailabilityPeriodTransfer->getWarehouseGroup() === $self->searchResult['periods'][0]['warehouseGroup']
                            && $restConditionalAvailabilityPeriodTransfer->getQty() === null;
                    },
                ),
            )->willReturnCallback(
                static function (
                    array $periodData,
                    RestConditionalAvailabilityPeriodTransfer $restConditionalAvailabilityPeriodTransfer
                ) {
                    return $restConditionalAvailabilityPeriodTransfer;
                },
            );

        $restConditionalAvailabilityPageSearchCollectionResponseTransfer = $this->conditionalAvailabilityPageSearchMapper
            ->mapSearchResultToRestConditionalAvailabilityPageSearchCollectionResponseTransfer($this->searchResult);

        static::assertCount(
            1,
            $restConditionalAvailabilityPageSearchCollectionResponseTransfer->getConditionalAvailabilityPeriods(),
        );
    }

    /**
     * @return void
     */
    public function testMapSearchResultToRestConditionalAvailabilityPageSearchCollectionResponseTransferEmpty(): void
    {
        $this->restConditionalAvailabilityPeriodMapperPluginMocks[0]->expects(static::never())
            ->method('mapPeriodDataToRestConditionalAvailabilityPeriodTransfer');

        $restConditionalAvailabilityPageSearchCollectionResponseTransfer = $this->conditionalAvailabilityPageSearchMapper
            ->mapSearchResultToRestConditionalAvailabilityPageSearchCollectionResponseTransfer([]);

        static::assertCount(
            0,
            $restConditionalAvailabilityPageSearchCollectionResponseTransfer->getConditionalAvailabilityPeriods(),
        );
    }
}
