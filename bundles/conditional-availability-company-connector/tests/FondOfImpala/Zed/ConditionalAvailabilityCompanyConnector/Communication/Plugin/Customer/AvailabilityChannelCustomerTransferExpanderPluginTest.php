<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCompanyConnector\Communication\Plugin\Customer;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityCompanyConnector\ConditionalAvailabilityCompanyConnectorConfig;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class AvailabilityChannelCustomerTransferExpanderPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityCompanyConnector\ConditionalAvailabilityCompanyConnectorConfig
     */
    protected MockObject|ConditionalAvailabilityCompanyConnectorConfig $configMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected MockObject|CustomerTransfer $companyTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected MockObject|CustomerTransfer $companyUserTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected MockObject|CustomerTransfer $customerTransferMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCompanyConnector\Communication\Plugin\Customer\AvailabilityChannelCustomerTransferExpanderPlugin
     */
    protected AvailabilityChannelCustomerTransferExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->configMock = $this->getMockBuilder(ConditionalAvailabilityCompanyConnectorConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new AvailabilityChannelCustomerTransferExpanderPlugin();
        $this->plugin->setConfig($this->configMock);
    }

    /**
     * @return void
     */
    public function testExpandTransfer(): void
    {
        $defaultAvailabilityChannel = 'default-availability-channel';
        $availabilityChannel = 'availability-channel';

        $this->configMock->expects($this->atLeastOnce())
            ->method('getDefaultAvailabilityChannel')
            ->willReturn($defaultAvailabilityChannel);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUserTransfer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getAvailabilityChannel')
            ->willReturn('availability-channel');

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getAvailabilityChannel')
            ->willReturn($availabilityChannel);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('setAvailabilityChannel')
            ->with($availabilityChannel)
            ->willReturnSelf();

        $customerTransfer = $this->plugin->expandTransfer($this->customerTransferMock);

        static::assertEquals(
            $this->customerTransferMock,
            $this->plugin->expandTransfer($this->customerTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testExpandTransferWithNoCompanyUser(): void
    {
        $defaultAvailabilityChannel = 'default-availability-channel';

        $this->configMock->expects($this->atLeastOnce())
            ->method('getDefaultAvailabilityChannel')
            ->willReturn($defaultAvailabilityChannel);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUserTransfer')
            ->willReturn(null);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('setAvailabilityChannel')
            ->with($defaultAvailabilityChannel)
            ->willReturnSelf();

        $customerTransfer = $this->plugin->expandTransfer($this->customerTransferMock);

        static::assertEquals(
            $this->customerTransferMock,
            $this->plugin->expandTransfer($this->customerTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testExpandTransferWithNoCompany(): void
    {
        $defaultAvailabilityChannel = 'default-availability-channel';

        $this->configMock->expects($this->atLeastOnce())
            ->method('getDefaultAvailabilityChannel')
            ->willReturn($defaultAvailabilityChannel);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUserTransfer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompany')
            ->willReturn(null);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('setAvailabilityChannel')
            ->with($defaultAvailabilityChannel)
            ->willReturnSelf();

        $customerTransfer = $this->plugin->expandTransfer($this->customerTransferMock);
    }
}
