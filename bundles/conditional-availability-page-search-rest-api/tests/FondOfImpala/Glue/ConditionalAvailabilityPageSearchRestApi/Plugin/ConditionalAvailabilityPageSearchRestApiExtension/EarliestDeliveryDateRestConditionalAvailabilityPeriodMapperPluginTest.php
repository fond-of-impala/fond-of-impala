<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Plugin\ConditionalAvailabilityPageSearchRestApiExtension;

use Codeception\Test\Unit;
use DateTime;
use FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\ConditionalAvailabilityPageSearchRestApiFactory;
use FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Processor\EarliestDeliveryDate\Generator\EarliestDeliveryDateGeneratorInterface;
use Generated\Shared\Transfer\RestConditionalAvailabilityPeriodTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class EarliestDeliveryDateRestConditionalAvailabilityPeriodMapperPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\ConditionalAvailabilityPageSearchRestApiFactory
     */
    protected MockObject|ConditionalAvailabilityPageSearchRestApiFactory $factoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Processor\EarliestDeliveryDate\Generator\EarliestDeliveryDateGeneratorInterface
     */
    protected MockObject|EarliestDeliveryDateGeneratorInterface $earliestDeliveryDateGeneratorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestConditionalAvailabilityPeriodTransfer
     */
    protected MockObject|RestConditionalAvailabilityPeriodTransfer $restConditionalAvailabilityPeriodTransferMock;

    /**
     * @var \FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Plugin\ConditionalAvailabilityPageSearchRestApiExtension\EarliestDeliveryDateRestConditionalAvailabilityPeriodMapperPlugin
     */
    protected EarliestDeliveryDateRestConditionalAvailabilityPeriodMapperPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchRestApiFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->earliestDeliveryDateGeneratorMock = $this->getMockBuilder(EarliestDeliveryDateGeneratorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restConditionalAvailabilityPeriodTransferMock = $this->getMockBuilder(RestConditionalAvailabilityPeriodTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new EarliestDeliveryDateRestConditionalAvailabilityPeriodMapperPlugin();
        $this->plugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testMapPeriodDataToRestConditionalAvailabilityPeriodTransferWithInvalidData(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createEarliestDeliveryDateGenerator')
            ->willReturn($this->earliestDeliveryDateGeneratorMock);

        $this->earliestDeliveryDateGeneratorMock->expects(static::atLeastOnce())
            ->method('generateByRestConditionalAvailabilityPeriodTransfer')
            ->with($this->restConditionalAvailabilityPeriodTransferMock)
            ->willReturn(null);

        $this->restConditionalAvailabilityPeriodTransferMock->expects(static::never())
            ->method('setEarliestDeliveryDate');

        $restConditionalAvailabilityPeriodTransfer = $this->plugin
            ->mapPeriodDataToRestConditionalAvailabilityPeriodTransfer(
                [],
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

        $this->factoryMock->expects(static::atLeastOnce())
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

        $restConditionalAvailabilityPeriodTransfer = $this->plugin
            ->mapPeriodDataToRestConditionalAvailabilityPeriodTransfer(
                [],
                $this->restConditionalAvailabilityPeriodTransferMock,
            );

        static::assertEquals(
            $this->restConditionalAvailabilityPeriodTransferMock,
            $restConditionalAvailabilityPeriodTransfer,
        );
    }
}
