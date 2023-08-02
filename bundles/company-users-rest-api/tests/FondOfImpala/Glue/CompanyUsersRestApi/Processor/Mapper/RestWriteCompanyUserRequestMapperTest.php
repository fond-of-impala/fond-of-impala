<?php

namespace FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper;

use Codeception\Test\Unit;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Filter\CompanyUserReferenceFilterInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Filter\IdCustomerFilterInterface;
use Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class RestWriteCompanyUserRequestMapperTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper\RestWriteCompanyUserRequestMapper
     */
    protected $restWriteCompanyUserRequestMapper;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\CompanyUsersRestApi\Processor\Filter\CompanyUserReferenceFilterInterface
     */
    protected $companyUserReferenceFilterMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\CompanyUsersRestApi\Processor\Filter\IdCustomerFilterInterface
     */
    protected $idCustomerFilterMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->idCustomerFilterMock = $this->getMockBuilder(IdCustomerFilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReferenceFilterMock = $this->getMockBuilder(CompanyUserReferenceFilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restWriteCompanyUserRequestMapper = new RestWriteCompanyUserRequestMapper(
            $this->idCustomerFilterMock,
            $this->companyUserReferenceFilterMock,
        );
    }

    /**
     * @return void
     */
    public function testFromRestRequest(): void
    {
        $this->idCustomerFilterMock->expects($this->atLeastOnce())
            ->method('filterFromRestRequest')
            ->with($this->restRequestMock)
            ->willReturn(1);

        $this->companyUserReferenceFilterMock->expects($this->atLeastOnce())
            ->method('filterFromRestRequest')
            ->with($this->restRequestMock)
            ->willReturn('company-user-reference');

        $this->assertInstanceOf(
            RestWriteCompanyUserRequestTransfer::class,
            $this->restWriteCompanyUserRequestMapper->fromRestRequest(
                $this->restRequestMock,
            ),
        );
    }
}
