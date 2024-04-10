<?php

namespace FondOfImpala\Glue\CustomerAppRestApi\Processor\CustomerApp;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCustomerAppRequestAttributesTransfer;
use JsonException;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerAppMapperTest extends Unit
{
    protected MockObject|CustomerTransfer $customerTransferMock;

    protected MockObject|RestCustomerAppRequestAttributesTransfer $restCustomerAppRequestAttributesTransferMock;

    protected CustomerAppMapper $mapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCustomerAppRequestAttributesTransferMock = $this->getMockBuilder(RestCustomerAppRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mapper = new CustomerAppMapper();
    }

    /**
     * @return void
     */
    public function testMapRestCustomerAppRequestAttributesTransferToCustomerTransfer(): void
    {
        $this->restCustomerAppRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getAppSettingsData')
            ->willReturn([]);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setAppSettingsData')
            ->with([]);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setAppSettings')
            ->with('[]');

        $this->mapper->mapRestCustomerAppRequestAttributesTransferToCustomerTransfer($this->customerTransferMock, $this->restCustomerAppRequestAttributesTransferMock);
    }

    /**
     * @return void
     */
    public function testMapRestCustomerAppRequestAttributesTransferToCustomerTransferException(): void
    {
        $this->restCustomerAppRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getAppSettingsData')
            ->willReturn(INF);

        $exception = null;
        try {
            $this->mapper->mapRestCustomerAppRequestAttributesTransferToCustomerTransfer($this->customerTransferMock, $this->restCustomerAppRequestAttributesTransferMock);
        } catch (JsonException $e) {
            $exception = $e;
        }

        static::assertNotNull($exception);
    }

    /**
     * @return void
     */
    public function testMapCustomerTransferToRestCustomerAppResponseAttributesTransfer(): void
    {
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getAppSettings')
            ->willReturn('[]');

        $restCustomerAppResponseAttributesTransfer = $this->mapper->mapCustomerTransferToRestCustomerAppResponseAttributesTransfer($this->customerTransferMock);

        static::assertEquals([], $restCustomerAppResponseAttributesTransfer->getAppSettingsData());
    }

    /**
     * @return void
     */
    public function testMapCustomerTransferToRestCustomerAppResponseAttributesTransferException(): void
    {
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getAppSettings')
            ->willReturn(INF);

        $restCustomerAppResponseAttributesTransfer = $this->mapper->mapCustomerTransferToRestCustomerAppResponseAttributesTransfer($this->customerTransferMock);

        static::assertEquals([], $restCustomerAppResponseAttributesTransfer->getAppSettingsData());
    }

    /**
     * @return void
     */
    public function testMapCustomerTransferToRestCustomerAppResponseAttributesTransferEmptySettings(): void
    {
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getAppSettings')
            ->willReturn(null);

        $restCustomerAppResponseAttributesTransfer = $this->mapper->mapCustomerTransferToRestCustomerAppResponseAttributesTransfer($this->customerTransferMock);

        static::assertEquals([], $restCustomerAppResponseAttributesTransfer->getAppSettingsData());
    }
}
