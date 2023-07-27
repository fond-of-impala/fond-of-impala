<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Communication\Plugin\Event\Listener;

use Codeception\Test\Unit;
use FondOfImpala\Shared\CompanyUsersBulkRestApi\CompanyUsersBulkRestApiConstants;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\CompanyUsersBulkRestApiFacade;
use Generated\Shared\Transfer\RestCompanyUsersBulkItemCollectionTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyUsersBulkRestApiCompanyUserCreatorListenerTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Communication\Plugin\Event\Listener\CompanyUsersBulkRestApiCompanyUserCreatorListener
     */
    protected CompanyUsersBulkRestApiCompanyUserCreatorListener $listener;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\CompanyUsersBulkRestApiFacade|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkRestApiFacade|MockObject $facadeMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUsersBulkItemCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCompanyUsersBulkItemCollectionTransfer|MockObject $restCompanyUsersBulkItemCollectionTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->facadeMock = $this->getMockBuilder(CompanyUsersBulkRestApiFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersBulkItemCollectionTransferMock = $this->getMockBuilder(RestCompanyUsersBulkItemCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->listener = new CompanyUsersBulkRestApiCompanyUserCreatorListener();
        $this->listener->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testHandle(): void
    {
        $this->facadeMock
            ->expects(static::atLeastOnce())
            ->method('createCompanyUserBulkMode')
            ->with($this->restCompanyUsersBulkItemCollectionTransferMock);

        $this->listener->handle($this->restCompanyUsersBulkItemCollectionTransferMock, CompanyUsersBulkRestApiConstants::BULK_ASSIGN);
    }
}
