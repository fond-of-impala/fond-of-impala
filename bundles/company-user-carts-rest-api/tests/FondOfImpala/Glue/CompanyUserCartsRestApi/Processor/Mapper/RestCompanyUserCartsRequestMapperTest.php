<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper;

use Codeception\Test\Unit;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter\CompanyUserReferenceFilterInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter\CustomerReferenceFilterInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter\IdCartFilterInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter\IdCustomerFilterInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class RestCompanyUserCartsRequestMapperTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter\IdCartFilterInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $cartIdFilterMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter\CompanyUserReferenceFilterInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserReferenceFilterMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter\CustomerReferenceFilterInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $customerReferenceFilterMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter\IdCustomerFilterInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $idCustomerFilterMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCompanyUserCartsRequestMapper
     */
    protected $restCompanyUserCartsRequestMapper;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer
     */
    protected $restCompanyUserCartsRequestTransfer;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->cartIdFilterMock = $this->getMockBuilder(IdCartFilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReferenceFilterMock = $this->getMockBuilder(CompanyUserReferenceFilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerReferenceFilterMock = $this->getMockBuilder(CustomerReferenceFilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idCustomerFilterMock = $this->getMockBuilder(IdCustomerFilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUserCartsRequestMapper = new RestCompanyUserCartsRequestMapper(
            $this->cartIdFilterMock,
            $this->companyUserReferenceFilterMock,
            $this->customerReferenceFilterMock,
            $this->idCustomerFilterMock,
        );
    }

    /**
     * @return void
     */
    public function testFromRestRequest(): void
    {
        $idCard = '71066382-5532-4b1a-99cb-cac70b2ce200';
        $companyUserReference = 'FOO--CU-1';
        $customerReference = 'FOO--C-1';
        $idCustomer = 1;

        $this->cartIdFilterMock->expects(static::atLeastOnce())
            ->method('filterFromRestRequest')
            ->with($this->restRequestMock)
            ->willReturn($idCard);

        $this->companyUserReferenceFilterMock->expects(static::atLeastOnce())
            ->method('filterFromRestRequest')
            ->with($this->restRequestMock)
            ->willReturn($companyUserReference);

        $this->customerReferenceFilterMock->expects(static::atLeastOnce())
            ->method('filterFromRestRequest')
            ->with($this->restRequestMock)
            ->willReturn($customerReference);

        $this->idCustomerFilterMock->expects(static::atLeastOnce())
            ->method('filterFromRestRequest')
            ->with($this->restRequestMock)
            ->willReturn($idCustomer);

        $this->restCompanyUserCartsRequestTransfer = $this->restCompanyUserCartsRequestMapper->fromRestRequest(
            $this->restRequestMock,
        );

        static::assertEquals(
            $idCard,
            $this->restCompanyUserCartsRequestTransfer->getIdCart(),
        );

        static::assertEquals(
            $companyUserReference,
            $this->restCompanyUserCartsRequestTransfer->getCompanyUserReference(),
        );

        static::assertEquals(
            $customerReference,
            $this->restCompanyUserCartsRequestTransfer->getCustomerReference(),
        );

        static::assertEquals(
            $idCustomer,
            $this->restCompanyUserCartsRequestTransfer->getIdCustomer(),
        );
    }
}
