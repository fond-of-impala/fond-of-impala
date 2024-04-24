<?php

namespace FondOfImpala\Zed\WebUiSettingsCustomerConnector\Communication\Plugin\Customer;

use Codeception\Test\Unit;
use FondOfImpala\Zed\WebUiSettingsCustomerConnector\Persistence\WebUiSettingsCustomerConnectorRepository;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\WebUiSettingsTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class WebUiSettingsCustomerTransferExpanderPluginTest extends Unit
{
    protected CustomerTransfer|MockObject $customerTransferMock;

    protected WebUiSettingsTransfer|MockObject $webUiSettingsTransferMock;

    protected WebUiSettingsCustomerConnectorRepository|MockObject $repositoryMock;

    protected WebUiSettingsCustomerTransferExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->webUiSettingsTransferMock = $this->getMockBuilder(WebUiSettingsTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(WebUiSettingsCustomerConnectorRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new WebUiSettingsCustomerTransferExpanderPlugin();
        $this->plugin->setRepository($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testExpandTransferWithData(): void
    {
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getFkWebUiSettings')
            ->willReturn(1);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn(100);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getWebUiSettings')
            ->willReturn(null);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setWebUiSettings')
            ->with($this->webUiSettingsTransferMock);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findWebUiSettingsByIdCustomer')
            ->willReturn($this->webUiSettingsTransferMock);

        $this->plugin->expandTransfer($this->customerTransferMock);
    }

    /**
     * @return void
     */
    public function testExpandTransfer(): void
    {
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getFkWebUiSettings')
            ->willReturn(null);

        $this->customerTransferMock->expects(static::never())
            ->method('getWebUiSettings');

        $this->customerTransferMock->expects(static::never())
            ->method('setWebUiSettings');

        $this->repositoryMock->expects(static::never())
            ->method('findWebUiSettingsByIdCustomer');

        $this->plugin->expandTransfer($this->customerTransferMock);
    }
}
