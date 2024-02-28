<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Persister;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Mapper\CustomerProductListRelationMapperInterface;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Dependency\Facade\CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeInterface;
use Generated\Shared\Transfer\CustomerProductListRelationTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerProductListRelationPersisterTest extends Unit
{
    protected MockObject|CustomerProductListRelationMapperInterface $customerProductListRelationMapperMock;

    protected MockObject|CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeInterface $customerProductListConnectorFacadeMock;

    protected RestProductListsBulkRequestAssignmentTransfer|MockObject $restProductListsBulkRequestAssignmentTransferMock;

    protected CustomerProductListRelationTransfer|MockObject $customerProductListRelationTransferMock;

    protected CustomerProductListRelationPersister $customerProductListRelationPersister;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->customerProductListRelationMapperMock = $this->getMockBuilder(CustomerProductListRelationMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerProductListConnectorFacadeMock = $this->getMockBuilder(CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestAssignmentTransferMock = $this->getMockBuilder(RestProductListsBulkRequestAssignmentTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerProductListRelationTransferMock = $this->getMockBuilder(CustomerProductListRelationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerProductListRelationPersister = new CustomerProductListRelationPersister(
            $this->customerProductListRelationMapperMock,
            $this->customerProductListConnectorFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testPersist(): void
    {
        $this->customerProductListRelationMapperMock->expects(static::atLeastOnce())
            ->method('fromRestProductListsBulkRequestAssignmentTransfer')
            ->with($this->restProductListsBulkRequestAssignmentTransferMock)
            ->willReturn($this->customerProductListRelationTransferMock);

        $this->customerProductListConnectorFacadeMock->expects(static::atLeastOnce())
            ->method('persistCustomerProductListRelation')
            ->with($this->customerProductListRelationTransferMock);

        $this->customerProductListRelationPersister->persist($this->restProductListsBulkRequestAssignmentTransferMock);
    }

    /**
     * @return void
     */
    public function testPersistWithInvalidMapperResult(): void
    {
        $this->customerProductListRelationMapperMock->expects(static::atLeastOnce())
            ->method('fromRestProductListsBulkRequestAssignmentTransfer')
            ->with($this->restProductListsBulkRequestAssignmentTransferMock)
            ->willReturn(null);

        $this->customerProductListConnectorFacadeMock->expects(static::never())
            ->method('persistCustomerProductListRelation');

        $this->customerProductListRelationPersister->persist($this->restProductListsBulkRequestAssignmentTransferMock);
    }
}
