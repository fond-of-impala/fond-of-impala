<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Mapper\ConditionalAvailabilityBulkApiMapperInterface;
use FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade\ConditionalAvailabilityBulkApiToApiFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade\ConditionalAvailabilityBulkApiToConditionalAvailabilityFacadeBridge;
use FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade\ConditionalAvailabilityBulkApiToProductFacadeInterface;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityBulkApiResponseTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;

class ConditionalAvailabilityBulkApiTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Mapper\ConditionalAvailabilityBulkApiMapperInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $conditionalAvailabilityBulkApiMapperMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade\ConditionalAvailabilityBulkApiToConditionalAvailabilityFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $conditionalAvailabilityFacadeMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade\ConditionalAvailabilityBulkApiToProductFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $productFacadeMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade\ConditionalAvailabilityBulkApiToApiFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiQueryContainerMock;

    /**
     * @var \Generated\Shared\Transfer\ApiDataTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiDataTransferMock;

    /**
     * @var array<string, array<string, \Generated\Shared\Transfer\ConditionalAvailabilityTransfer|\PHPUnit\Framework\MockObject\MockObject>>
     */
    protected $groupedConditionalAvailabilityTransferMocks;

    /**
     * @var array<\Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer>|array<\PHPUnit\Framework\MockObject\MockObject>
     */
    protected $conditionalAvailabilityResponseTransferMocks;

    /**
     * @var \Generated\Shared\Transfer\ConditionalAvailabilityTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $conditionalAvailabilityTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ApiItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiItemTransferMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Model\ConditionalAvailabilityBulkApi
     */
    protected $conditionalAvailabilityBulkApi;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->conditionalAvailabilityBulkApiMapperMock = $this->getMockBuilder(ConditionalAvailabilityBulkApiMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityFacadeMock = $this->getMockBuilder(ConditionalAvailabilityBulkApiToConditionalAvailabilityFacadeBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productFacadeMock = $this->getMockBuilder(ConditionalAvailabilityBulkApiToProductFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiQueryContainerMock = $this->getMockBuilder(ConditionalAvailabilityBulkApiToApiFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiDataTransferMock = $this->getMockBuilder(ApiDataTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->groupedConditionalAvailabilityTransferMocks = [
            'FOO' => [
                'BAR-1' => $this->getMockBuilder(ConditionalAvailabilityTransfer::class)
                    ->disableOriginalConstructor()
                    ->getMock(),
                'BAR-2' => $this->getMockBuilder(ConditionalAvailabilityTransfer::class)
                    ->disableOriginalConstructor()
                    ->getMock(),
                'BAR-3' => $this->getMockBuilder(ConditionalAvailabilityTransfer::class)
                    ->disableOriginalConstructor()
                    ->getMock(),
            ],
        ];

        $this->conditionalAvailabilityResponseTransferMocks = [
            $this->getMockBuilder(ConditionalAvailabilityResponseTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(ConditionalAvailabilityResponseTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->conditionalAvailabilityTransferMock = $this->getMockBuilder(ConditionalAvailabilityTransfer::class)
                ->disableOriginalConstructor()
                ->getMock();

        $this->apiItemTransferMock = $this->getMockBuilder(ApiItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityBulkApi = new ConditionalAvailabilityBulkApi(
            $this->conditionalAvailabilityBulkApiMapperMock,
            $this->conditionalAvailabilityFacadeMock,
            $this->productFacadeMock,
            $this->apiQueryContainerMock,
        );
    }

    /**
     * @return void
     */
    public function testPersist(): void
    {
        $ids = ['BAR-1' => 1, 'BAR-2' => 2, 'BAR-3' => null];
        $skus = array_keys($ids);

        $this->conditionalAvailabilityBulkApiMapperMock->expects(static::atLeastOnce())
            ->method('mapApiDataTransferToGroupedConditionalAvailabilityTransfers')
            ->with($this->apiDataTransferMock)
            ->willReturn($this->groupedConditionalAvailabilityTransferMocks);

        $this->productFacadeMock->expects(static::atLeastOnce())
            ->method('getProductConcreteIdsByConcreteSkus')
            ->with($skus)
            ->willReturn($ids);

        $this->groupedConditionalAvailabilityTransferMocks['FOO']['BAR-1']->expects(static::atLeastOnce())
            ->method('setFkProduct')
            ->with($ids['BAR-1'])
            ->willReturn($this->groupedConditionalAvailabilityTransferMocks['FOO']['BAR-1']);

        $this->groupedConditionalAvailabilityTransferMocks['FOO']['BAR-2']->expects(static::atLeastOnce())
            ->method('setFkProduct')
            ->with($ids['BAR-2'])
            ->willReturn($this->groupedConditionalAvailabilityTransferMocks['FOO']['BAR-2']);

        $this->groupedConditionalAvailabilityTransferMocks['FOO']['BAR-3']->expects(static::atLeastOnce())
            ->method('setFkProduct')
            ->with($ids['BAR-3'])
            ->willReturn($this->groupedConditionalAvailabilityTransferMocks['FOO']['BAR-3']);

        $this->groupedConditionalAvailabilityTransferMocks['FOO']['BAR-1']->expects(static::atLeastOnce())
            ->method('getFkProduct')
            ->willReturn($ids['BAR-1']);

        $this->groupedConditionalAvailabilityTransferMocks['FOO']['BAR-2']->expects(static::atLeastOnce())
            ->method('getFkProduct')
            ->willReturn($ids['BAR-2']);

        $this->groupedConditionalAvailabilityTransferMocks['FOO']['BAR-3']->expects(static::atLeastOnce())
            ->method('getFkProduct')
            ->willReturn($ids['BAR-3']);

        $this->conditionalAvailabilityFacadeMock->expects(static::atLeastOnce())
            ->method('persistConditionalAvailability')
            ->withConsecutive(
                [$this->groupedConditionalAvailabilityTransferMocks['FOO']['BAR-1']],
                [$this->groupedConditionalAvailabilityTransferMocks['FOO']['BAR-2']],
            )->willReturnOnConsecutiveCalls(
                $this->conditionalAvailabilityResponseTransferMocks[0],
                $this->conditionalAvailabilityResponseTransferMocks[1],
            );

        $this->conditionalAvailabilityResponseTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityTransfer')
            ->willReturn($this->conditionalAvailabilityTransferMock);

        $this->conditionalAvailabilityResponseTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getIdConditionalAvailability')
            ->willReturn($ids['BAR-1']);

        $this->conditionalAvailabilityResponseTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityTransfer')
            ->willReturn(null);

        $this->apiQueryContainerMock->expects(static::atLeastOnce())
            ->method('createApiItem')
            ->with(
                static::callback(
                    static function (ConditionalAvailabilityBulkApiResponseTransfer $transfer) use ($ids) {
                        return count($transfer->getConditionalAvailabilityIds()) === 1
                            && $transfer->getConditionalAvailabilityIds()[0] === $ids['BAR-1'];
                    },
                ),
                null,
            )->willReturn($this->apiItemTransferMock);

        static::assertEquals(
            $this->apiItemTransferMock,
            $this->conditionalAvailabilityBulkApi->persist($this->apiDataTransferMock),
        );
    }
}
