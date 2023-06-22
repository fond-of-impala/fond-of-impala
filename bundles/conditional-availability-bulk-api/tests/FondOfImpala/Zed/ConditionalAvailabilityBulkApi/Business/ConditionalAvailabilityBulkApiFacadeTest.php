<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Model\ConditionalAvailabilityBulkApiInterface;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;

class ConditionalAvailabilityBulkApiFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\ConditionalAvailabilityBulkApiBusinessFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $businessFactoryMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Model\ConditionalAvailabilityBulkApiInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $conditionalAvailabilityBulkApiMock;

    /**
     * @var \Generated\Shared\Transfer\ApiDataTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiDataTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ApiItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiItemTransferMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\ConditionalAvailabilityBulkApiFacade
     */
    protected $facade;

    /**
     * @Override
     *
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->businessFactoryMock = $this->getMockBuilder(ConditionalAvailabilityBulkApiBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityBulkApiMock = $this->getMockBuilder(ConditionalAvailabilityBulkApiInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiDataTransferMock = $this->getMockBuilder(ApiDataTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiItemTransferMock = $this->getMockBuilder(ApiItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new ConditionalAvailabilityBulkApiFacade();
        $this->facade->setFactory($this->businessFactoryMock);
    }

    /**
     * @return void
     */
    public function testPersistConditionalAvailabilities(): void
    {
        $this->businessFactoryMock->expects(static::atLeastOnce())
            ->method('createConditionalAvailabilitiesBulkApi')
            ->willReturn($this->conditionalAvailabilityBulkApiMock);

        $this->conditionalAvailabilityBulkApiMock->expects(static::atLeastOnce())
            ->method('persist')
            ->with($this->apiDataTransferMock)
            ->willReturn($this->apiItemTransferMock);

        static::assertEquals(
            $this->apiItemTransferMock,
            $this->facade->persistConditionalAvailabilities($this->apiDataTransferMock),
        );
    }
}
