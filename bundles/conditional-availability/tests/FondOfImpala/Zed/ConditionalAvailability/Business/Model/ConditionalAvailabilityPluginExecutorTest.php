<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityExtension\Dependency\Plugin\ConditionalAvailabilityPostSavePluginInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityPluginExecutorTest extends Unit
{
    /**
     * @var (\Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ConditionalAvailabilityResponseTransfer $conditionalAvailabilityResponseTransferMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityExtension\Dependency\Plugin\ConditionalAvailabilityPostSavePluginInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityPostSavePluginInterface|MockObject $conditionalAvailabilityPostSavePluginMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityPluginExecutor
     */
    protected ConditionalAvailabilityPluginExecutor $conditionalAvailabilityPluginExecutor;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->conditionalAvailabilityResponseTransferMock = $this->getMockBuilder(ConditionalAvailabilityResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPostSavePluginMock = $this->getMockBuilder(ConditionalAvailabilityPostSavePluginInterface::class)
                ->disableOriginalConstructor()
                ->getMock();

        $this->conditionalAvailabilityPluginExecutor = new ConditionalAvailabilityPluginExecutor(
            [
                $this->conditionalAvailabilityPostSavePluginMock,
            ],
        );
    }

    /**
     * @return void
     */
    public function testExecutePostSavePlugins(): void
    {
        $this->conditionalAvailabilityPostSavePluginMock->expects(static::atLeastOnce())
            ->method('postSave')
            ->with($this->conditionalAvailabilityResponseTransferMock)
            ->willReturn($this->conditionalAvailabilityResponseTransferMock);

        static::assertEquals(
            $this->conditionalAvailabilityResponseTransferMock,
            $this->conditionalAvailabilityPluginExecutor->executePostSavePlugins(
                $this->conditionalAvailabilityResponseTransferMock,
            ),
        );
    }
}
