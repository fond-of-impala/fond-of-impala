<?php

namespace FondOfImpala\Zed\WebUiSettings\Business\Manager;

use Codeception\Test\Unit;
use FondOfImpala\Zed\WebUiSettings\Persistence\WebUiSettingsEntityManagerInterface;
use Generated\Shared\Transfer\WebUiSettingsTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class WebUiSettingsManagerTest extends Unit
{
    protected WebUiSettingsTransfer|MockObject $webUiSettingsTransferMock;

    protected WebUiSettingsEntityManagerInterface|MockObject $entityManagerMock;

    protected WebUiSettingsManager $manager;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->webUiSettingsTransferMock = $this->getMockBuilder(WebUiSettingsTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->entityManagerMock = $this->getMockBuilder(WebUiSettingsEntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->manager = new WebUiSettingsManager(
            $this->entityManagerMock,
        );
    }

    /**
     * @return void
     */
    public function testHandleCreate(): void
    {
        $this->entityManagerMock->expects(static::atLeastOnce())
            ->method('createWebUiSettings')
            ->willReturn($this->webUiSettingsTransferMock);

        $this->entityManagerMock->expects(static::never())
            ->method('updateWebUiSettingsById');

        $this->webUiSettingsTransferMock->expects(static::atLeastOnce())
            ->method('getIdWebUiSettings')
            ->willReturn(null);

        $this->manager->handle($this->webUiSettingsTransferMock);
    }

    /**
     * @return void
     */
    public function testHandleUpdate(): void
    {
        $this->entityManagerMock->expects(static::never())
            ->method('createWebUiSettings');

        $this->entityManagerMock->expects(static::atLeastOnce())
            ->method('updateWebUiSettingsById')
            ->willReturn($this->webUiSettingsTransferMock);

        $this->webUiSettingsTransferMock->expects(static::atLeastOnce())
            ->method('getIdWebUiSettings')
            ->willReturn(1);

        $this->manager->handle($this->webUiSettingsTransferMock);
    }
}
