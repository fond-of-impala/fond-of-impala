<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Persister;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Mapper\CompanyProductListRelationMapperInterface;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Dependency\Facade\CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeInterface;
use Generated\Shared\Transfer\CompanyProductListRelationTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyProductListRelationPersisterTest extends Unit
{
    protected MockObject|CompanyProductListRelationMapperInterface $companyProductListRelationMapperMock;

    protected MockObject|CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeInterface $companyProductListConnectorFacadeMock;

    protected RestProductListsBulkRequestAssignmentTransfer|MockObject $restProductListsBulkRequestAssignmentTransferMock;

    protected CompanyProductListRelationTransfer|MockObject $companyProductListRelationTransferMock;

    protected CompanyProductListRelationPersister $companyProductListRelationPersister;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyProductListRelationMapperMock = $this->getMockBuilder(CompanyProductListRelationMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyProductListConnectorFacadeMock = $this->getMockBuilder(CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestAssignmentTransferMock = $this->getMockBuilder(RestProductListsBulkRequestAssignmentTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyProductListRelationTransferMock = $this->getMockBuilder(CompanyProductListRelationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyProductListRelationPersister = new CompanyProductListRelationPersister(
            $this->companyProductListRelationMapperMock,
            $this->companyProductListConnectorFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testPersist(): void
    {
        $this->companyProductListRelationMapperMock->expects(static::atLeastOnce())
            ->method('fromRestProductListsBulkRequestAssignmentTransfer')
            ->with($this->restProductListsBulkRequestAssignmentTransferMock)
            ->willReturn($this->companyProductListRelationTransferMock);

        $this->companyProductListConnectorFacadeMock->expects(static::atLeastOnce())
            ->method('persistCompanyProductListRelation')
            ->with($this->companyProductListRelationTransferMock);

        $this->companyProductListRelationPersister->persist($this->restProductListsBulkRequestAssignmentTransferMock);
    }

    /**
     * @return void
     */
    public function testPersistWithInvalidMapperResult(): void
    {
        $this->companyProductListRelationMapperMock->expects(static::atLeastOnce())
            ->method('fromRestProductListsBulkRequestAssignmentTransfer')
            ->with($this->restProductListsBulkRequestAssignmentTransferMock)
            ->willReturn(null);

        $this->companyProductListConnectorFacadeMock->expects(static::never())
            ->method('persistCompanyProductListRelation');

        $this->companyProductListRelationPersister->persist($this->restProductListsBulkRequestAssignmentTransferMock);
    }
}
