<?php

namespace FondOfImpala\Glue\WebUiSettings\Processor\WebUiSettings;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestWebUiSettingsRequestAttributesTransfer;
use Generated\Shared\Transfer\WebUiSettingsTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class WebUiSettingsMapperTest extends Unit
{
    protected MockObject|CustomerTransfer $customerTransferMock;

    protected MockObject|RestWebUiSettingsRequestAttributesTransfer $restWebUiSettingsRequestAttributesTransferMock;

    protected MockObject|WebUiSettingsTransfer $webUiSettingsTransferMock;

    protected WebUiSettingsMapper $mapper;

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

        $this->restWebUiSettingsRequestAttributesTransferMock = $this->getMockBuilder(RestWebUiSettingsRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mapper = new WebUiSettingsMapper();
    }

    /**
     * @return void
     */
    public function testMapRestWebUiSettingsRequestAttributesTransferToCustomerTransfer(): void
    {
        $this->restWebUiSettingsRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getWebUiSettings')
            ->willReturn($this->webUiSettingsTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setWebUiSettings')
            ->with($this->webUiSettingsTransferMock)
            ->willReturnSelf();

        $this->mapper->mapRestWebUiSettingsRequestAttributesTransferToCustomerTransfer($this->customerTransferMock, $this->restWebUiSettingsRequestAttributesTransferMock);
    }

    /**
     * @return void
     */
    public function testMapCustomerTransferToRestWebUiSettingsResponseAttributesTransfer(): void
    {
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getWebUiSettings')
            ->willReturn($this->webUiSettingsTransferMock);

        $restWebUiSettingsResponseAttributesTransfer = $this->mapper->mapCustomerTransferToRestWebUiSettingsResponseAttributesTransfer($this->customerTransferMock);

        static::assertEquals($this->webUiSettingsTransferMock, $restWebUiSettingsResponseAttributesTransfer->getWebUiSettings());
    }

    /**
     * @return void
     */
    public function testMapCustomerTransferToRestWebUiSettingsResponseAttributesTransferEmptySettings(): void
    {
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getWebUiSettings')
            ->willReturn(null);

        $restWebUiSettingsResponseAttributesTransfer = $this->mapper->mapCustomerTransferToRestWebUiSettingsResponseAttributesTransfer($this->customerTransferMock);

        static::assertNull($restWebUiSettingsResponseAttributesTransfer->getWebUiSettings());
    }
}
