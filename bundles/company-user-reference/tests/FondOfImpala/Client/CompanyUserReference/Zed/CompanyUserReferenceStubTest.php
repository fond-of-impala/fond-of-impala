<?php

namespace FondOfImpala\Client\CompanyUserReference\Zed;

use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyUserReference\Dependency\Client\CompanyUserReferenceToZedRequestClientInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyUserReferenceStubTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\CompanyUserReference\Zed\CompanyUserReferenceStub
     */
    protected $companyUserReferenceStub;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CompanyUserReference\Dependency\Client\CompanyUserReferenceToZedRequestClientInterface
     */
    protected $companyUserReferenceToZedRequestClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    protected $companyUserResponseTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUserReferenceToZedRequestClientInterfaceMock = $this->getMockBuilder(CompanyUserReferenceToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->url = '/company-user-reference/gateway/find-company-user-by-company-user-reference';

        $this->companyUserReferenceStub = new CompanyUserReferenceStub(
            $this->companyUserReferenceToZedRequestClientInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testFindCompanyUserByCompanyUserReference(): void
    {
        $this->companyUserReferenceToZedRequestClientInterfaceMock->expects($this->atLeastOnce())
            ->method('call')
            ->with(
                $this->url,
                $this->companyUserTransferMock,
            )->willReturn($this->companyUserResponseTransferMock);

        $this->assertInstanceOf(
            CompanyUserResponseTransfer::class,
            $this->companyUserReferenceStub->findCompanyUserByCompanyUserReference(
                $this->companyUserTransferMock,
            ),
        );
    }
}
