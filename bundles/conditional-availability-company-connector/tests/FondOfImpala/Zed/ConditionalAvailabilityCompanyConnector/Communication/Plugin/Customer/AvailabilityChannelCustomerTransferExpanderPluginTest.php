<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCompanyConnector\Communication\Plugin\Customer;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class AvailabilityChannelCustomerTransferExpanderPluginTest extends Unit
{
    /**
     * @var (\Generated\Shared\Transfer\CompanyTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyTransfer|MockObject $companyTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\CompanyUserTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserTransfer|MockObject $companyUserTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\CustomerTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerTransfer|MockObject $customerTransferMock;

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
    }

    /**
     * @return void
     */
    public function testExpandTransfer(): void
    {
        $availabilityChannel = 'availability-channel';

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserTransfer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects(static::atLeastOnce())
            ->method('getAvailabilityChannel')
            ->willReturn($availabilityChannel);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setAvailabilityChannel')
            ->with($availabilityChannel)
            ->willReturnSelf();

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
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserTransfer')
            ->willReturn(null);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setAvailabilityChannel')
            ->with(null)
            ->willReturnSelf();

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
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserTransfer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn(null);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setAvailabilityChannel')
            ->with(null)
            ->willReturnSelf();

        static::assertEquals(
            $this->customerTransferMock,
            $this->plugin->expandTransfer($this->customerTransferMock),
        );
    }
}
