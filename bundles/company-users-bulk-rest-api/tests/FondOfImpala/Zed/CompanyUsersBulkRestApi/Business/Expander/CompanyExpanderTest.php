<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Expander;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepository;
use Generated\Shared\Transfer\CompanyUsersBulkCompanyCollectionTransfer;
use Generated\Shared\Transfer\CompanyUsersBulkCompanyTransfer;
use Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer;
use Generated\Shared\Transfer\CompanyUsersBulkPreparationTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkItemCompanyTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkItemTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyExpanderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Expander\CompanyExpander
     */
    protected CompanyExpander $expander;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepository|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkRestApiRepository|MockObject $repositoryMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkPreparationCollectionTransfer|MockObject $companyUsersBulkPreparationCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUsersBulkCompanyCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkCompanyCollectionTransfer|MockObject $companyCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUsersBulkCompanyTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkCompanyTransfer|MockObject $companyTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUsersBulkPreparationTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkPreparationTransfer|MockObject $companyUsersBulkPreparationTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUsersBulkItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCompanyUsersBulkItemTransfer|MockObject $restCompanyUsersBulkItemTransfer;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUsersBulkItemCompanyTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCompanyUsersBulkItemCompanyTransfer|MockObject $restCompanyUsersBulkItemCompanyTransfer;

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

        $this->companyCollectionTransferMock = $this->getMockBuilder(CompanyUsersBulkCompanyCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyUsersBulkCompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersBulkPreparationTransferMock = $this->getMockBuilder(CompanyUsersBulkPreparationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersBulkItemTransfer = $this->getMockBuilder(RestCompanyUsersBulkItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersBulkItemCompanyTransfer = $this->getMockBuilder(RestCompanyUsersBulkItemCompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expander = new CompanyExpander($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->repositoryMock
            ->expects(static::atLeastOnce())
            ->method('findCompaniesByUuids')
            ->willReturn($this->companyCollectionTransferMock);

        $this->companyUsersBulkPreparationCollectionTransferMock
            ->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn([$this->companyUsersBulkPreparationTransferMock]);

        $this->companyUsersBulkPreparationTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn(null);

        $this->companyUsersBulkPreparationTransferMock
            ->expects(static::atLeastOnce())
            ->method('getItem')
            ->willReturn($this->restCompanyUsersBulkItemTransfer);

        $this->restCompanyUsersBulkItemTransfer
            ->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restCompanyUsersBulkItemCompanyTransfer);

        $this->restCompanyUsersBulkItemCompanyTransfer
            ->expects(static::atLeastOnce())
            ->method('getCompanyId')
            ->willReturn('uuid');

        $this->companyTransferMock
            ->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturn('uuid');

        $this->companyCollectionTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCompanies')
            ->willReturn([$this->companyTransferMock]);

        $this->expander->expand($this->companyUsersBulkPreparationCollectionTransferMock);
    }
}
