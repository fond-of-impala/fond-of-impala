<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Expander;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepository;
use Generated\Shared\Transfer\CompanyUsersBulkCustomerCollectionTransfer;
use Generated\Shared\Transfer\CompanyUsersBulkCustomerTransfer;
use Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer;
use Generated\Shared\Transfer\CompanyUsersBulkPreparationTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkItemCustomerTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkItemTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerByReferenceExpanderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Expander\CustomerByReferenceExpander
     */
    protected CustomerByReferenceExpander $expander;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepository|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkRestApiRepository|MockObject $repositoryMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkPreparationCollectionTransfer|MockObject $companyUsersBulkPreparationCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUsersBulkCustomerCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkCustomerCollectionTransfer|MockObject $customerCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUsersBulkCustomerTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkCustomerTransfer|MockObject $customerTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUsersBulkPreparationTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkPreparationTransfer|MockObject $companyUsersBulkPreparationTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUsersBulkItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCompanyUsersBulkItemTransfer|MockObject $restCompanyUsersBulkItemTransfer;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUsersBulkItemCustomerTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCompanyUsersBulkItemCustomerTransfer|MockObject $restCompanyUsersBulkItemCustomerTransfer;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->repositoryMock = $this->getMockBuilder(CompanyUsersBulkRestApiRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersBulkPreparationCollectionTransferMock = $this->getMockBuilder(CompanyUsersBulkPreparationCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerCollectionTransferMock = $this->getMockBuilder(CompanyUsersBulkCustomerCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CompanyUsersBulkCustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersBulkPreparationTransferMock = $this->getMockBuilder(CompanyUsersBulkPreparationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersBulkItemTransfer = $this->getMockBuilder(RestCompanyUsersBulkItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersBulkItemCustomerTransfer = $this->getMockBuilder(RestCompanyUsersBulkItemCustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expander = new CustomerByReferenceExpander($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->repositoryMock
            ->expects(static::atLeastOnce())
            ->method('findCustomerByReferences')
            ->willReturn($this->customerCollectionTransferMock);

        $this->companyUsersBulkPreparationCollectionTransferMock
            ->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn([$this->companyUsersBulkPreparationTransferMock]);

        $this->companyUsersBulkPreparationTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn(null);

        $this->companyUsersBulkPreparationTransferMock
            ->expects(static::atLeastOnce())
            ->method('getItem')
            ->willReturn($this->restCompanyUsersBulkItemTransfer);

        $this->restCompanyUsersBulkItemTransfer
            ->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restCompanyUsersBulkItemCustomerTransfer);

        $this->restCompanyUsersBulkItemCustomerTransfer
            ->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn('ref');

        $this->customerTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn('ref');

        $this->customerCollectionTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCustomers')
            ->willReturn([$this->customerTransferMock]);

        $this->expander->expand($this->companyUsersBulkPreparationCollectionTransferMock);
    }
}
