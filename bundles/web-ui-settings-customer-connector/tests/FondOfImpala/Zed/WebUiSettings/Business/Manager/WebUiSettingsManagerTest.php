<?php

namespace FondOfImpala\Zed\WebUiSettingsCustomerConnector\Business\Manager;

use Codeception\Test\Unit;
use FondOfImpala\Zed\WebUiSettingsCustomerConnector\Dependency\Facade\WebUiSettingsCustomerConnectorToWebUiSettingsFacadeInterface;
use FondOfImpala\Zed\WebUiSettingsCustomerConnector\Persistence\WebUiSettingsCustomerConnectorRepositoryInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\WebUiSettingsTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class WebUiSettingsManagerTest extends Unit
{
    protected QuoteTransfer|MockObject $quoteTransferMock;

    protected CustomerTransfer|MockObject $customerTransferMock;

    protected WebUiSettingsTransfer|MockObject $webUiSettingsTransferMock;

    protected WebUiSettingsCustomerConnectorRepositoryInterface|MockObject $repositoryMock;

    protected WebUiSettingsCustomerConnectorToWebUiSettingsFacadeInterface|MockObject $webUiSettingsFacade;

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

        $this->webUiSettingsFacade = $this->getMockBuilder(WebUiSettingsCustomerConnectorToWebUiSettingsFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(WebUiSettingsCustomerConnectorRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->manager = new WebUiSettingsManager(
            $this->webUiSettingsFacade,
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

        $this->webUiSettingsFacade->expects(static::never())
            ->method('handleWebUiSettings');

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

        $this->webUiSettingsFacade->expects(static::atLeastOnce())
            ->method('handleWebUiSettings')
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

        $this->webUiSettingsFacade->expects(static::atLeastOnce())
            ->method('handleWebUiSettings')
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
