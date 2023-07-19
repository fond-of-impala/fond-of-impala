<?php

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Communication\Plugin\Event\Listener;

use Codeception\Test\Unit;
use FondOfImpala\Shared\CustomerAnonymizerCompanyUserConnector\CustomerAnonymizerCompanyUserConnectorConstants;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business\CustomerAnonymizerCompanyUserConnectorFacade;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business\CustomerAnonymizerCompanyUserConnectorFacadeInterface;
use Generated\Shared\Transfer\CompanyUserIdCollectionTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyUserDeleterListenerTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business\CustomerAnonymizerCompanyUserConnectorFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerAnonymizerCompanyUserConnectorFacadeInterface|MockObject $facadeMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserIdCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserIdCollectionTransfer|MockObject $companyUserIdCollectionTransferMock;

    /**
     * @var \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Communication\Plugin\Event\Listener\CompanyUserDeleterListener
     */
    protected CompanyUserDeleterListener $listener;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(CustomerAnonymizerCompanyUserConnectorFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserIdCollectionTransferMock = $this->getMockBuilder(CompanyUserIdCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->listener = new CompanyUserDeleterListener();
        $this->listener->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testHandle(): void
    {
        $this->facadeMock
            ->expects(static::once())
            ->method('deleteCompanyUsersByCompanyUserIdCollection');

        $this->listener->handle(
            $this->companyUserIdCollectionTransferMock,
            CustomerAnonymizerCompanyUserConnectorConstants::EVENT_DELETE_COMPANY_USER,
        );
    }
}
