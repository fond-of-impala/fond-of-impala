<?php

namespace FondOfImpala\Zed\WebUiSettings\Communication\Plugin\Customer;

use Codeception\Test\Unit;
use FondOfImpala\Zed\WebUiSettings\Business\WebUiSettingsFacade;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class WebUiSettingsCustomerPreUpdatePluginTest extends Unit
{
    protected CustomerTransfer|MockObject $customerTransferMock;

    protected WebUiSettingsFacade|MockObject $facadeMock;

    protected WebUiSettingsCustomerPreUpdatePlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadeMock = $this->getMockBuilder(WebUiSettingsFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new WebUiSettingsCustomerPreUpdatePlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testExecute(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('handleWebUiSettings')
            ->with($this->customerTransferMock);

        $this->plugin->execute($this->customerTransferMock);
    }
}
