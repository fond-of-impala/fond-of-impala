<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityExtension\Dependency\Plugin\ConditionalAvailabilityPostSavePluginInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer;

class ConditionalAvailabilityPluginExecutorTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityPluginExecutor
     */
    protected $conditionalAvailabilityPluginExecutor;

    /**
     * @var array<\FondOfImpala\Zed\ConditionalAvailabilityExtension\Dependency\Plugin\ConditionalAvailabilityPostSavePluginInterface>|array<\PHPUnit\Framework\MockObject\MockObject>
     */
    protected $conditionalAvailabilityPostSavePluginMocks;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer
     */
    protected $conditionalAvailabilityResponseTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->conditionalAvailabilityResponseTransferMock = $this->getMockBuilder(ConditionalAvailabilityResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPostSavePluginMocks = [
            $this->getMockBuilder(ConditionalAvailabilityPostSavePluginInterface::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->conditionalAvailabilityPluginExecutor = new ConditionalAvailabilityPluginExecutor(
            $this->conditionalAvailabilityPostSavePluginMocks,
        );
    }

    /**
     * @return void
     */
    public function testExecutePostSavePlugins(): void
    {
        $this->conditionalAvailabilityPostSavePluginMocks[0]->expects($this->atLeastOnce())
            ->method('postSave')
            ->with($this->conditionalAvailabilityResponseTransferMock)
            ->willReturn($this->conditionalAvailabilityResponseTransferMock);

        $this->assertEquals(
            $this->conditionalAvailabilityResponseTransferMock,
            $this->conditionalAvailabilityPluginExecutor->executePostSavePlugins(
                $this->conditionalAvailabilityResponseTransferMock,
            ),
        );
    }
}
