<?php

namespace FondOfImpala\Glue\WebUiSettings\Processor\WebUiSettings;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Glue\WebUiSettings\Dependency\Client\WebUiSettingsToCustomerClientInterface;
use FondOfImpala\Glue\WebUiSettings\Processor\Validation\RestApiErrorInterface;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestWebUiSettingsRequestAttributesTransfer;
use Generated\Shared\Transfer\RestWebUiSettingsResponseAttributesTransfer;
use JsonException;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CustomerUpdaterTest extends Unit
{
    protected MockObject|WebUiSettingsToCustomerClientInterface $customerClientMock;

    protected MockObject|WebUiSettingsMapperInterface $customerAppMapperMock;

    protected MockObject|RestApiErrorInterface $restApiErrorMock;

    protected MockObject|RestResponseInterface $restResponseMock;

    protected MockObject|RestResourceInterface $restResourceMock;

    protected MockObject|RestResourceBuilderInterface $restResourceBuilderMock;

    protected MockObject|CustomerTransfer $customerTransferMock;

    protected MockObject|RestWebUiSettingsResponseAttributesTransfer $restWebUiSettingsResponseAttributesTransferMock;

    protected MockObject|CustomerResponseTransfer $customerResponseTransferMock;

    protected MockObject|RestRequestInterface $restRequestMock;

    protected MockObject|RestWebUiSettingsRequestAttributesTransfer $restWebUiSettingsRequestAttributesTransferMock;

    protected CustomerUpdater $updater;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->customerClientMock = $this->getMockBuilder(WebUiSettingsToCustomerClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerAppMapperMock = $this->getMockBuilder(WebUiSettingsMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restApiErrorMock = $this->getMockBuilder(RestApiErrorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceBuilderMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restWebUiSettingsResponseAttributesTransferMock = $this->getMockBuilder(RestWebUiSettingsResponseAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerResponseTransferMock = $this->getMockBuilder(CustomerResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restWebUiSettingsRequestAttributesTransferMock = $this->getMockBuilder(RestWebUiSettingsRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->updater = new CustomerUpdater(
            $this->customerClientMock,
            $this->customerAppMapperMock,
            $this->restApiErrorMock,
            $this->restResourceBuilderMock,
        );
    }

    /**
     * @return void
     */
    public function testUpdateCustomer(): void
    {
        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getResource')
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn('1');

        $this->customerClientMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerClientMock->expects(static::atLeastOnce())
            ->method('updateCustomer')
            ->willReturn($this->customerResponseTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn('1');

        $this->customerAppMapperMock->expects(static::atLeastOnce())
            ->method('mapRestWebUiSettingsRequestAttributesTransferToCustomerTransfer')
            ->willReturn($this->customerTransferMock);

        $this->customerResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(true);

        $this->customerResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerTransfer')
            ->willReturn($this->customerTransferMock);

        $this->customerAppMapperMock->expects(static::atLeastOnce())
            ->method('mapCustomerTransferToRestWebUiSettingsResponseAttributesTransfer')
            ->willReturn($this->restWebUiSettingsResponseAttributesTransferMock);

        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResource')
            ->willReturn($this->restResourceMock);

        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('addResource')
            ->willReturnSelf();

        $this->updater->updateCustomer($this->restRequestMock, $this->restWebUiSettingsRequestAttributesTransferMock);
    }

    /**
     * @return void
     */
    public function testUpdateCustomerReferenceMissing(): void
    {
        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getResource')
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn(null);

        $this->restApiErrorMock->expects(static::atLeastOnce())
            ->method('addCustomerReferenceMissingError')
            ->willReturn($this->restResponseMock);

        $this->updater->updateCustomer($this->restRequestMock, $this->restWebUiSettingsRequestAttributesTransferMock);
    }

    /**
     * @return void
     */
    public function testUpdateCustomerCustomerNotMatch(): void
    {
        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getResource')
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn('1');

        $this->customerClientMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn('2');

        $this->restApiErrorMock->expects(static::atLeastOnce())
            ->method('addCustomerNotMatchError')
            ->willReturn($this->restResponseMock);

        $this->updater->updateCustomer($this->restRequestMock, $this->restWebUiSettingsRequestAttributesTransferMock);
    }

    /**
     * @return void
     */
    public function testUpdateCustomerJsonException(): void
    {
        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getResource')
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn('1');

        $this->customerClientMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn('1');

        $this->customerAppMapperMock->expects(static::atLeastOnce())
            ->method('mapRestWebUiSettingsRequestAttributesTransferToCustomerTransfer')
            ->willThrowException(new JsonException());

        $this->restApiErrorMock->expects(static::atLeastOnce())
            ->method('addWebUiSettingsDataInvalidError')
            ->willReturn($this->restResponseMock);

        $this->updater->updateCustomer($this->restRequestMock, $this->restWebUiSettingsRequestAttributesTransferMock);
    }

    /**
     * @return void
     */
    public function testUpdateCustomerException(): void
    {
        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getResource')
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn('1');

        $this->customerClientMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn('1');

        $this->customerAppMapperMock->expects(static::atLeastOnce())
            ->method('mapRestWebUiSettingsRequestAttributesTransferToCustomerTransfer')
            ->willThrowException(new Exception());

        $this->restApiErrorMock->expects(static::atLeastOnce())
            ->method('addWebUiSettingsDataNotUpdatedError')
            ->willReturn($this->restResponseMock);

        $this->updater->updateCustomer($this->restRequestMock, $this->restWebUiSettingsRequestAttributesTransferMock);
    }

    /**
     * @return void
     */
    public function testUpdateCustomerNoSuccess(): void
    {
        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getResource')
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn('1');

        $this->customerClientMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerClientMock->expects(static::atLeastOnce())
            ->method('updateCustomer')
            ->willReturn($this->customerResponseTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn('1');

        $this->customerAppMapperMock->expects(static::atLeastOnce())
            ->method('mapRestWebUiSettingsRequestAttributesTransferToCustomerTransfer')
            ->willReturn($this->customerTransferMock);

        $this->customerResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(false);

        $this->restApiErrorMock->expects(static::atLeastOnce())
            ->method('addWebUiSettingsDataNotUpdatedError')
            ->willReturn($this->restResponseMock);

        $this->updater->updateCustomer($this->restRequestMock, $this->restWebUiSettingsRequestAttributesTransferMock);
    }
}
