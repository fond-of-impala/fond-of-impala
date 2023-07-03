<?php

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Communication\Plugin\Customer;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business\CustomerAnonymizerCompanyUserConnectorFacade;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyUserDeleterBeforeCustomerAnonymizerPluginTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerTransfer|MockObject $customerTransfer;

    /**
     * @var (\FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business\CustomerAnonymizerCompanyUserConnectorFacade&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerAnonymizerCompanyUserConnectorFacade|MockObject $facadeMock;

    /**
     * @var \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Communication\Plugin\Customer\CompanyUserDeleterBeforeCustomerAnonymizerPlugin
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

        $this->facadeMock = $this->getMockBuilder(CustomerAnonymizerCompanyUserConnectorFacade::class)
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
            ->method('deleteCompanyUsersForCustomer')
            ->with($this->customerTransfer);

        $this->plugin->process(
            $this->customerTransfer,
        );
    }
}
