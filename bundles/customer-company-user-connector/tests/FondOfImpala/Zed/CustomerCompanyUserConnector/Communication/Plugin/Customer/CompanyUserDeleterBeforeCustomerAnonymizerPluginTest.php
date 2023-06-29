<?php

namespace FondOfImpala\Zed\CustomerCompanyUserConnector\Communication\Plugin\Customer;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CustomerCompanyUserConnector\Business\CustomerCompanyUserConnectorFacade;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyUserDeleterBeforeCustomerAnonymizerPluginTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerTransfer|MockObject $customerTransfer;

    /**
     * @var (\FondOfImpala\Zed\CustomerCompanyUserConnector\Business\CustomerCompanyUserConnectorFacade&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerCompanyUserConnectorFacade|MockObject $facadeMock;

    /**
     * @var \FondOfImpala\Zed\CustomerCompanyUserConnector\Communication\Plugin\Customer\CompanyUserDeleterBeforeCustomerAnonymizerPlugin
     */
    protected CompanyUserDeleterBeforeCustomerAnonymizerPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->customerTransfer = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadeMock = $this->getMockBuilder(CustomerCompanyUserConnectorFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new CompanyUserDeleterBeforeCustomerAnonymizerPlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testProcess(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('deleteCompanyUserForCustomer')
            ->with($this->customerTransfer);

        $this->plugin->process(
            $this->customerTransfer,
        );
    }
}
