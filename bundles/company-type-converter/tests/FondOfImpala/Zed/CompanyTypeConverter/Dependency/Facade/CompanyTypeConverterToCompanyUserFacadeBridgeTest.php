<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;
use Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface;

class CompanyTypeConverterToCompanyUserFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface
     */
    protected $companyUserFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    protected $companyUserCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer
     */
    protected $companyUserCriteriaFilterTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyUserFacadeBridge
     */
    protected $companyTypeConverterToCompanyUserFacadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyUserFacadeMock = $this->getMockBuilder(CompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCollectionTransferMock = $this->getMockBuilder(CompanyUserCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCriteriaFilterTransferMock = $this->getMockBuilder(CompanyUserCriteriaFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeConverterToCompanyUserFacadeBridge = new CompanyTypeConverterToCompanyUserFacadeBridge(
            $this->companyUserFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetCompanyUserCollection(): void
    {
        $this->companyUserFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyUserCollection')
            ->with($this->companyUserCriteriaFilterTransferMock)
            ->willReturn($this->companyUserCollectionTransferMock);

        $companyUserCollectionTransfer = $this->companyTypeConverterToCompanyUserFacadeBridge
            ->getCompanyUserCollection($this->companyUserCriteriaFilterTransferMock);

        $this->assertEquals($this->companyUserCollectionTransferMock, $companyUserCollectionTransfer);
        $this->assertInstanceOf(
            CompanyUserCollectionTransfer::class,
            $companyUserCollectionTransfer,
        );
    }
}
