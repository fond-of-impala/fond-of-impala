<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Manager\BulkManagerInterface;
use Generated\Shared\Transfer\RestCompanyUsersBulkItemCollectionTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyUsersBulkRestApiFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\CompanyUsersBulkRestApiFacade
     */
    protected CompanyUsersBulkRestApiFacade $facade;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\CompanyUsersBulkRestApiBusinessFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkRestApiBusinessFactory|MockObject $factoryMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Manager\BulkManagerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected BulkManagerInterface|MockObject $bulkManagerMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCompanyUsersBulkRequestTransfer|MockObject $restCompanyUsersBulkRequestTransfer;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCompanyUsersBulkResponseTransfer|MockObject $restCompanyUsersBulkResponseTransfer;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUsersBulkItemCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCompanyUsersBulkItemCollectionTransfer|MockObject $restCompanyUsersBulkItemCollectionTransfer;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->factoryMock = $this->getMockBuilder(CompanyUsersBulkRestApiBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bulkManagerMock = $this
            ->getMockBuilder(BulkManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersBulkRequestTransfer = $this
            ->getMockBuilder(RestCompanyUsersBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersBulkResponseTransfer = $this
            ->getMockBuilder(RestCompanyUsersBulkResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersBulkItemCollectionTransfer = $this
            ->getMockBuilder(RestCompanyUsersBulkItemCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new CompanyUsersBulkRestApiFacade();
        $this->facade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testBulkProcess(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createBulkManager')
            ->willReturn($this->bulkManagerMock);

        $this->bulkManagerMock->expects(static::atLeastOnce())
            ->method('handleBulkRequest')
            ->with($this->restCompanyUsersBulkRequestTransfer)
            ->willReturn($this->restCompanyUsersBulkResponseTransfer);

        static::assertEquals(
            $this->restCompanyUsersBulkResponseTransfer,
            $this->facade->bulkProcess(
                $this->restCompanyUsersBulkRequestTransfer,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserBulkMode(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createBulkManager')
            ->willReturn($this->bulkManagerMock);

        $this->bulkManagerMock->expects(static::atLeastOnce())
            ->method('createCompanyUser')
            ->with($this->restCompanyUsersBulkItemCollectionTransfer);

        $this->facade->createCompanyUserBulkMode(
            $this->restCompanyUsersBulkItemCollectionTransfer,
        );
    }

    /**
     * @return void
     */
    public function testDeleteCompanyUserBulkMode(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createBulkManager')
            ->willReturn($this->bulkManagerMock);

        $this->bulkManagerMock->expects(static::atLeastOnce())
            ->method('deleteCompanyUser')
            ->with($this->restCompanyUsersBulkItemCollectionTransfer);

        $this->facade->deleteCompanyUserBulkMode(
            $this->restCompanyUsersBulkItemCollectionTransfer,
        );
    }
}
