<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Processor\ConditionalAvailabilityPageSearch\Mapper;

use Codeception\Test\Unit;
use FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApiExtension\Dependency\Plugin\RestConditionalAvailabilityPeriodMapperPluginInterface;
use Generated\Shared\Transfer\RestConditionalAvailabilityPeriodTransfer;

class ConditionalAvailabilityPageSearchMapperTest extends Unit
{
    /**
     * @var array<\PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApiExtension\Dependency\Plugin\RestConditionalAvailabilityPeriodMapperPluginInterface>
     */
    protected array $restConditionalAvailabilityPeriodMapperPluginMocks;

    /**
     * @var \FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Processor\ConditionalAvailabilityPageSearch\Mapper\ConditionalAvailabilityPageSearchMapper
     */
    protected ConditionalAvailabilityPageSearchMapper $mapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restConditionalAvailabilityPeriodMapperPluginMocks = [
            $this->getMockBuilder(RestConditionalAvailabilityPeriodMapperPluginInterface::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->mapper = new ConditionalAvailabilityPageSearchMapper(
            $this->restConditionalAvailabilityPeriodMapperPluginMocks,
        );
    }

    /**
     * @return void
     */
    public function testMapSearchResultToRestConditionalAvailabilityPageSearchCollectionResponseTransfer(): void
    {
        $searchResult = [
            'periods' => [
                [
                    'quantity' => 12,
                    'sku' => 'FOO-BAR-001-001',
                    'warehouseGroup' => 'EU',
                ],
            ],
        ];

        $this->restConditionalAvailabilityPeriodMapperPluginMocks[0]->expects(static::atLeastOnce())
            ->method('mapPeriodDataToRestConditionalAvailabilityPeriodTransfer')
            ->with(
                $searchResult['periods'][0],
                static::callback(
                    static fn (RestConditionalAvailabilityPeriodTransfer $restConditionalAvailabilityPeriodTransfer): bool => $restConditionalAvailabilityPeriodTransfer->getSku() === $searchResult['periods'][0]['sku']
                        && $restConditionalAvailabilityPeriodTransfer->getWarehouseGroup() === $searchResult['periods'][0]['warehouseGroup']
                        && $restConditionalAvailabilityPeriodTransfer->getQty() === null,
                ),
            )->willReturnCallback(
                static fn (array $periodData, RestConditionalAvailabilityPeriodTransfer $restConditionalAvailabilityPeriodTransfer): RestConditionalAvailabilityPeriodTransfer => $restConditionalAvailabilityPeriodTransfer,
            );

        $restConditionalAvailabilityPageSearchCollectionResponseTransfer = $this->mapper
            ->mapSearchResultToRestConditionalAvailabilityPageSearchCollectionResponseTransfer($searchResult);

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

        $restConditionalAvailabilityPageSearchCollectionResponseTransfer = $this->mapper
            ->mapSearchResultToRestConditionalAvailabilityPageSearchCollectionResponseTransfer([]);

        static::assertCount(
            0,
            $restConditionalAvailabilityPageSearchCollectionResponseTransfer->getConditionalAvailabilityPeriods(),
        );
    }
}
