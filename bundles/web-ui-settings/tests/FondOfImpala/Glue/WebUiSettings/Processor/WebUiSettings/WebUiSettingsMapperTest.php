<?php

namespace FondOfImpala\Glue\WebUiSettings\Processor\WebUiSettings;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestWebUiSettingsRequestAttributesTransfer;
use JsonException;
use PHPUnit\Framework\MockObject\MockObject;

class WebUiSettingsMapperTest extends Unit
{
    protected MockObject|CustomerTransfer $customerTransferMock;

    protected MockObject|RestWebUiSettingsRequestAttributesTransfer $restWebUiSettingsRequestAttributesTransferMock;

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
            ->method('getAppSettingsData')
            ->willReturn([]);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setAppSettingsData')
            ->with([]);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setAppSettings')
            ->with('[]');

        $this->mapper->mapRestWebUiSettingsRequestAttributesTransferToCustomerTransfer($this->customerTransferMock, $this->restWebUiSettingsRequestAttributesTransferMock);
    }

    /**
     * @return void
     */
    public function testMapRestWebUiSettingsRequestAttributesTransferToCustomerTransferException(): void
    {
        $this->restWebUiSettingsRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getAppSettingsData')
            ->willReturn(INF);

        $exception = null;
        try {
            $this->mapper->mapRestWebUiSettingsRequestAttributesTransferToCustomerTransfer($this->customerTransferMock, $this->restWebUiSettingsRequestAttributesTransferMock);
        } catch (JsonException $e) {
            $exception = $e;
        }

        static::assertNotNull($exception);
    }

    /**
     * @return void
     */
    public function testMapCustomerTransferToRestWebUiSettingsResponseAttributesTransfer(): void
    {
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getAppSettings')
            ->willReturn('[]');

        $restWebUiSettingsResponseAttributesTransfer = $this->mapper->mapCustomerTransferToRestWebUiSettingsResponseAttributesTransfer($this->customerTransferMock);

        static::assertEquals([], $restWebUiSettingsResponseAttributesTransfer->getAppSettingsData());
    }

    /**
     * @return void
     */
    public function testMapCustomerTransferToRestWebUiSettingsResponseAttributesTransferException(): void
    {
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getAppSettings')
            ->willReturn(INF);

        $restWebUiSettingsResponseAttributesTransfer = $this->mapper->mapCustomerTransferToRestWebUiSettingsResponseAttributesTransfer($this->customerTransferMock);

        static::assertEquals([], $restWebUiSettingsResponseAttributesTransfer->getAppSettingsData());
    }

    /**
     * @return void
     */
    public function testMapCustomerTransferToRestWebUiSettingsResponseAttributesTransferEmptySettings(): void
    {
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getAppSettings')
            ->willReturn(null);

        $restWebUiSettingsResponseAttributesTransfer = $this->mapper->mapCustomerTransferToRestWebUiSettingsResponseAttributesTransfer($this->customerTransferMock);

        static::assertEquals([], $restWebUiSettingsResponseAttributesTransfer->getAppSettingsData());
    }
}
