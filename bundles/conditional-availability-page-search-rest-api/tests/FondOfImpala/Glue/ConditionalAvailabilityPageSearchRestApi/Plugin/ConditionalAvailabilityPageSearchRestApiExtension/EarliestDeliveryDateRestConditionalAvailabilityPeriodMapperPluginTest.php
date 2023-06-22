<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Plugin\ConditionalAvailabilityPageSearchRestApiExtension;

use Codeception\Test\Unit;
use DateTime;
use FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\ConditionalAvailabilityPageSearchRestApiFactory;
use FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Processor\EarliestDeliveryDate\Generator\EarliestDeliveryDateGeneratorInterface;
use Generated\Shared\Transfer\RestConditionalAvailabilityPeriodTransfer;

class EarliestDeliveryDateRestConditionalAvailabilityPeriodMapperPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\ConditionalAvailabilityPageSearchRestApiFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $conditionalAvailabilityPageSearchRestApiFactoryMock;

    /**
     * @var \FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Processor\EarliestDeliveryDate\Generator\EarliestDeliveryDateGeneratorInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $earliestDeliveryDateGeneratorMock;

    /**
     * @var \Generated\Shared\Transfer\RestConditionalAvailabilityPeriodTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restConditionalAvailabilityPeriodTransferMock;

    /**
     * @var array
     */
    protected $periodData;

    /**
     * @var \FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Plugin\ConditionalAvailabilityPageSearchRestApiExtension\EarliestDeliveryDateRestConditionalAvailabilityPeriodMapperPlugin
     */
    protected $earliestDeliveryDateRestConditionalAvailabilityPeriodMapperPlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->conditionalAvailabilityPageSearchRestApiFactoryMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchRestApiFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->earliestDeliveryDateGeneratorMock = $this->getMockBuilder(EarliestDeliveryDateGeneratorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restConditionalAvailabilityPeriodTransferMock = $this->getMockBuilder(RestConditionalAvailabilityPeriodTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->periodData = [];

        $this->earliestDeliveryDateRestConditionalAvailabilityPeriodMapperPlugin = new EarliestDeliveryDateRestConditionalAvailabilityPeriodMapperPlugin();
        $this->earliestDeliveryDateRestConditionalAvailabilityPeriodMapperPlugin->setFactory(
            $this->conditionalAvailabilityPageSearchRestApiFactoryMock,
        );
    }

    /**
     * @return void
     */
    public function testMapPeriodDataToRestConditionalAvailabilityPeriodTransferWithInvalidData(): void
    {
        $this->conditionalAvailabilityPageSearchRestApiFactoryMock->expects(static::atLeastOnce())
            ->method('createEarliestDeliveryDateGenerator')
            ->willReturn($this->earliestDeliveryDateGeneratorMock);

        $this->earliestDeliveryDateGeneratorMock->expects(static::atLeastOnce())
            ->method('generateByRestConditionalAvailabilityPeriodTransfer')
            ->with($this->restConditionalAvailabilityPeriodTransferMock)
            ->willReturn(null);

        $this->restConditionalAvailabilityPeriodTransferMock->expects(static::never())
            ->method('setEarliestDeliveryDate');

        $restConditionalAvailabilityPeriodTransfer = $this->earliestDeliveryDateRestConditionalAvailabilityPeriodMapperPlugin
            ->mapPeriodDataToRestConditionalAvailabilityPeriodTransfer(
                $this->periodData,
                $this->restConditionalAvailabilityPeriodTransferMock,
            );

        static::assertEquals(
            $this->restConditionalAvailabilityPeriodTransferMock,
            $restConditionalAvailabilityPeriodTransfer,
        );
    }

    /**
     * @return void
     */
    public function testMapPeriodDataToRestConditionalAvailabilityPeriodTransfer(): void
    {
        $earliestDeliveryDate = (new DateTime())->setTime(0, 0);
        $formattedEarliestDeliveryDate = $earliestDeliveryDate->format('Y-m-d H:i:s');

        $this->conditionalAvailabilityPageSearchRestApiFactoryMock->expects(static::atLeastOnce())
            ->method('createEarliestDeliveryDateGenerator')
            ->willReturn($this->earliestDeliveryDateGeneratorMock);

        $this->earliestDeliveryDateGeneratorMock->expects(static::atLeastOnce())
            ->method('generateByRestConditionalAvailabilityPeriodTransfer')
            ->with($this->restConditionalAvailabilityPeriodTransferMock)
            ->willReturn($earliestDeliveryDate);

        $this->restConditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('setEarliestDeliveryDate')
            ->with($formattedEarliestDeliveryDate)
            ->willReturn($this->restConditionalAvailabilityPeriodTransferMock);

        $restConditionalAvailabilityPeriodTransfer = $this->earliestDeliveryDateRestConditionalAvailabilityPeriodMapperPlugin
            ->mapPeriodDataToRestConditionalAvailabilityPeriodTransfer(
                $this->periodData,
                $this->restConditionalAvailabilityPeriodTransferMock,
            );

        static::assertEquals(
            $this->restConditionalAvailabilityPeriodTransferMock,
            $restConditionalAvailabilityPeriodTransfer,
        );
    }
}
