<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Expander\RestProductListsBulkRequestExpanderInterface;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Persister\CustomerProductListRelationPersisterInterface;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerProductListsBulkRestApiFacadeTest extends Unit
{
    protected CustomerProductListsBulkRestApiBusinessFactory|MockObject $factoryMock;

    protected MockObject|RestProductListsBulkRequestExpanderInterface $restProductListsBulkRequestExpanderMock;

    protected MockObject|RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransferMock;

    protected CustomerProductListRelationPersisterInterface|MockObject $customerProductListRelationPersisterMock;

    protected RestProductListsBulkRequestAssignmentTransfer|MockObject $restProductListsBulkRequestAssignmentTransferMock;

    protected CustomerProductListsBulkRestApiFacade $facade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(CustomerProductListsBulkRestApiBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestExpanderMock = $this->getMockBuilder(RestProductListsBulkRequestExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestTransferMock = $this->getMockBuilder(RestProductListsBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerProductListRelationPersisterMock = $this->getMockBuilder(CustomerProductListRelationPersisterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestAssignmentTransferMock = $this->getMockBuilder(RestProductListsBulkRequestAssignmentTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new CustomerProductListsBulkRestApiFacade();
        $this->facade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testExpandRestProductListsBulkRequest(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createRestProductListsBulkRequestExpander')
            ->willReturn($this->restProductListsBulkRequestExpanderMock);

        $this->restProductListsBulkRequestExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->restProductListsBulkRequestTransferMock)
            ->willReturn($this->restProductListsBulkRequestTransferMock);

        static::assertEquals(
            $this->restProductListsBulkRequestTransferMock,
            $this->facade->expandRestProductListsBulkRequest($this->restProductListsBulkRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testPersistCustomerProductListRelation(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCustomerProductListRelationPersister')
            ->willReturn($this->customerProductListRelationPersisterMock);

        $this->customerProductListRelationPersisterMock->expects(static::atLeastOnce())
            ->method('persist')
            ->with($this->restProductListsBulkRequestAssignmentTransferMock);

        $this->facade->persistCustomerProductListRelation($this->restProductListsBulkRequestAssignmentTransferMock);
    }
}
