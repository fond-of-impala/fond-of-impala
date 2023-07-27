<?php

namespace FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestCompanyUsersBulkRequestAttributesTransfer;
use Generated\Shared\Transfer\RestUserTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class RestCompanyUsersBulkRequestMapperTest extends Unit
{
    /**
     * @var \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestRequestInterface|MockObject $restRequestMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUsersBulkRequestAttributesTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCompanyUsersBulkRequestAttributesTransfer|MockObject $requestAttributesTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestUserTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestUserTransfer|MockObject $restUserTransfer;

    /**
     * @var \FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\Mapper\RestCompanyUsersBulkRequestMapper
     */
    protected RestCompanyUsersBulkRequestMapper $mapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->requestAttributesTransferMock = $this->getMockBuilder(RestCompanyUsersBulkRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restUserTransfer = $this->getMockBuilder(RestUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mapper = new RestCompanyUsersBulkRequestMapper();
    }

    /**
     * @return void
     */
    public function testCreateRequest(): void
    {
        $identifier = 'asd';

        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getAttributesDataFromRequest')
            ->willReturn([]);

        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getRestUser')
            ->willReturn($this->restUserTransfer);

        $this->restUserTransfer->expects(static::atLeastOnce())
            ->method('getNaturalIdentifier')
            ->willReturn($identifier);

        $result = $this->mapper->createRequest($this->restRequestMock);

        static::assertEquals($identifier, $result->getOriginatorReference());
    }
}
