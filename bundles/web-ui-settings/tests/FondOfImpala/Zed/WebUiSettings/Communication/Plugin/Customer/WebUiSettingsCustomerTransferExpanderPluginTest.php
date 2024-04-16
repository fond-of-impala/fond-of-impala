<?php

namespace FondOfImpala\Zed\WebUiSettings\Communication\Plugin\Customer;

use Codeception\Test\Unit;
use FondOfImpala\Zed\WebUiSettings\Communication\WebUiSettingsCommunicationFactory;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;

class WebUiSettingsCustomerTransferExpanderPluginTest extends Unit
{
    protected CustomerTransfer|MockObject $customerTransferMock;

    protected WebUiSettingsCommunicationFactory|MockObject $factoryMock;

    protected LoggerInterface|MockObject $loggerMock;

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

        $this->factoryMock = $this->getMockBuilder(WebUiSettingsCommunicationFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->loggerMock = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new WebUiSettingsCustomerTransferExpanderPlugin();
        $this->plugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testExpandTransfer(): void
    {
        $settings = null;

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getAppSettings')
            ->willReturn($settings);

        $this->customerTransferMock->expects(static::never())
            ->method('setAppSettingsData');

        $this->factoryMock->expects(static::never())
            ->method('getProvidedLogger');

        $this->plugin->expandTransfer($this->customerTransferMock);
    }

    /**
     * @return void
     */
    public function testExpandTransferWithData(): void
    {
        $settings = '{}';

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getAppSettings')
            ->willReturn($settings);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setAppSettingsData')
            ->with([]);

        $this->factoryMock->expects(static::never())
            ->method('getProvidedLogger');

        $this->plugin->expandTransfer($this->customerTransferMock);
    }

    /**
     * @return void
     */
    public function testExpandTransferWithException(): void
    {
        $settings = '{xxx}';

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getAppSettings')
            ->willReturn($settings);

        $this->customerTransferMock->expects(static::never())
            ->method('setAppSettingsData');

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getProvidedLogger')
            ->willReturn($this->loggerMock);

        $this->loggerMock->expects(static::atLeastOnce())
            ->method('error');

        $this->plugin->expandTransfer($this->customerTransferMock);
    }
}
