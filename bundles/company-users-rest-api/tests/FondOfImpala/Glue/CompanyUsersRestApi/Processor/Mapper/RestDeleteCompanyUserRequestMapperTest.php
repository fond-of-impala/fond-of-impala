<?php

namespace FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper;

use Codeception\Test\Unit;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Filter\CompanyUserReferenceFilterInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Filter\IdCustomerFilterInterface;
use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class RestDeleteCompanyUserRequestMapperTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper\RestDeleteCompanyUserRequestMapper
     */
    protected $restDeleteCompanyUserRequestMapper;

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

        $this->restDeleteCompanyUserRequestMapper = new RestDeleteCompanyUserRequestMapper(
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
            RestDeleteCompanyUserRequestTransfer::class,
            $this->restDeleteCompanyUserRequestMapper->fromRestRequest(
                $this->restRequestMock,
            ),
        );
    }
}
