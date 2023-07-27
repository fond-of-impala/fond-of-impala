<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Communication\Plugin;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\CompanyUsersBulkRestApiFacade;
use Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyResolverPreDataExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Communication\Plugin\CompanyResolverPreDataExpanderPlugin
     */
    protected CompanyResolverPreDataExpanderPlugin $plugin;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\CompanyUsersBulkRestApiFacade|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkRestApiFacade|MockObject $facade;

    /**
     * @var \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkPreparationCollectionTransfer|MockObject $companyUsersBulkPreparationCollectionTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->facade = $this->getMockBuilder(CompanyUsersBulkRestApiFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersBulkPreparationCollectionTransferMock = $this->getMockBuilder(CompanyUsersBulkPreparationCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new CompanyResolverPreDataExpanderPlugin();
        $this->plugin->setFacade($this->facade);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->facade
            ->expects(static::atLeastOnce())
            ->method('expandWithCompany')
            ->willReturn($this->companyUsersBulkPreparationCollectionTransferMock);

        $this->plugin->expand($this->companyUsersBulkPreparationCollectionTransferMock);
    }
}
