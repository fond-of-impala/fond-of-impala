<?php

namespace FondOfImpala\Zed\WebUiSettings\Business\Manager;

use Codeception\Test\Unit;
use FondOfImpala\Zed\WebUiSettings\Persistence\WebUiSettingsEntityManagerInterface;
use FondOfImpala\Zed\WebUiSettings\Persistence\WebUiSettingsRepositoryInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\WebUiSettingsTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class WebUiSettingsManagerTest extends Unit
{
    protected QuoteTransfer|MockObject $quoteTransferMock;

    protected CustomerTransfer|MockObject $customerTransferMock;

    protected WebUiSettingsTransfer|MockObject $webUiSettingsTransferMock;

    protected WebUiSettingsRepositoryInterface|MockObject $repositoryMock;

    protected WebUiSettingsEntityManagerInterface|MockObject $entityManagerMock;

    protected WebUiSettingsManager $manager;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->webUiSettingsTransferMock = $this->getMockBuilder(WebUiSettingsTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->entityManagerMock = $this->getMockBuilder(WebUiSettingsEntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(WebUiSettingsRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->manager = new WebUiSettingsManager(
            $this->entityManagerMock,
            $this->repositoryMock,
        );
    }

    /**
     * @return void
     */
    public function testHandleCustomerWebUiSettings(): void
    {
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getWebUiSettings')
            ->willReturn(null);

        $this->entityManagerMock->expects(static::never())
            ->method('createWebUiSettings');

        $this->entityManagerMock->expects(static::never())
            ->method('updateWebUiSettingsById');

        $this->manager->handleCustomerWebUiSettings($this->customerTransferMock);
    }

    /**
     * @return void
     */
    public function testHandleCustomerWebUiSettingsCreate(): void
    {
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getWebUiSettings')
            ->willReturn($this->webUiSettingsTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn(1);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findWebUiSettingsByIdCustomer')
            ->willReturn(null);

        $this->entityManagerMock->expects(static::atLeastOnce())
            ->method('createWebUiSettings')
            ->willReturn($this->webUiSettingsTransferMock);

        $this->entityManagerMock->expects(static::never())
            ->method('updateWebUiSettingsById');

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setWebUiSettings')
            ->willReturnSelf();

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setFkWebUiSettings')
            ->willReturnSelf();

        $this->webUiSettingsTransferMock->expects(static::atLeastOnce())
            ->method('getIdWebUiSettings')
            ->willReturn(1);

        $this->manager->handleCustomerWebUiSettings($this->customerTransferMock);
    }

    /**
     * @return void
     */
    public function testHandleCustomerWebUiSettingsUpdate(): void
    {
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getWebUiSettings')
            ->willReturn($this->webUiSettingsTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn(1);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findWebUiSettingsByIdCustomer')
            ->willReturn($this->webUiSettingsTransferMock);

        $this->entityManagerMock->expects(static::never())
            ->method('createWebUiSettings');

        $this->entityManagerMock->expects(static::atLeastOnce())
            ->method('updateWebUiSettingsById')
            ->willReturn($this->webUiSettingsTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setWebUiSettings')
            ->willReturnSelf();

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setFkWebUiSettings')
            ->willReturnSelf();

        $this->webUiSettingsTransferMock->expects(static::atLeastOnce())
            ->method('getIdWebUiSettings')
            ->willReturn(1);

        $this->webUiSettingsTransferMock->expects(static::atLeastOnce())
            ->method('fromArray')
            ->willReturnSelf();

        $this->webUiSettingsTransferMock->expects(static::atLeastOnce())
            ->method('modifiedToArray')
            ->willReturn([]);

        $this->webUiSettingsTransferMock->expects(static::atLeastOnce())
            ->method('setIdWebUiSettings')
            ->willReturnSelf();

        $this->manager->handleCustomerWebUiSettings($this->customerTransferMock);
    }
}
