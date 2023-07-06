<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCompanyConnector\Communication\Plugin\Customer;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityCompanyConnector\Persistence\ConditionalAvailabilityCompanyConnectorRepository;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PossibleAvailabilityChannelsCustomerTransferExpanderPluginTest extends Unit
{
    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityCompanyConnector\Persistence\ConditionalAvailabilityCompanyConnectorRepository&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityCompanyConnectorRepository|MockObject $repositoryMock;

    /**
     * @var (\Generated\Shared\Transfer\CustomerTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerTransfer|MockObject $customerTransferMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCompanyConnector\Communication\Plugin\Customer\PossibleAvailabilityChannelsCustomerTransferExpanderPlugin
     */
    protected PossibleAvailabilityChannelsCustomerTransferExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this->getMockBuilder(ConditionalAvailabilityCompanyConnectorRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new PossibleAvailabilityChannelsCustomerTransferExpanderPlugin();
        $this->plugin->setRepository($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testExpandTransfer(): void
    {
        $idCustomer = 1;
        $possibleAvailabilityChannels = ['FOO', 'BAR'];

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($idCustomer);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getPossibleAvailabilityChannelsByIdCustomer')
            ->with($idCustomer)
            ->willReturn($possibleAvailabilityChannels);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setPossibleAvailabilityChannels')
            ->with($possibleAvailabilityChannels)
            ->willReturn($this->customerTransferMock);

        static::assertEquals(
            $this->customerTransferMock,
            $this->plugin->expandTransfer($this->customerTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testExpandTransferWithoutIdCustomer(): void
    {
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn(null);

        $this->repositoryMock->expects(static::never())
            ->method('getPossibleAvailabilityChannelsByIdCustomer');

        $this->customerTransferMock->expects(static::never())
            ->method('setPossibleAvailabilityChannels');

        static::assertEquals(
            $this->customerTransferMock,
            $this->plugin->expandTransfer($this->customerTransferMock),
        );
    }
}
