<?php

namespace FondOfImpala\Client\CompanyType\Zed;

use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyType\Dependency\Client\CompanyTypeToZedRequestClientInterface;
use Generated\Shared\Transfer\CompanyTypeResponseTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

class CompanyTypeStubTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\CompanyType\Zed\CompanyTypeStub
     */
    protected $companyTypeStub;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CompanyType\Dependency\Client\CompanyTypeToZedRequestClientInterface
     */
    protected $companyTypeToZedRequestClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTypeTransfer
     */
    protected $companyTypeTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTypeResponseTransfer
     */
    protected $companyTypeResponseTransferMock;

    /**
     * @var string
     */
    protected $url;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyTypeToZedRequestClientInterfaceMock = $this->getMockBuilder(CompanyTypeToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeTransferMock = $this->getMockBuilder(CompanyTypeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeResponseTransferMock = $this->getMockBuilder(CompanyTypeResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->url = '/company-type/gateway/find-company-type-by-id';

        $this->companyTypeStub = new CompanyTypeStub(
            $this->companyTypeToZedRequestClientInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testFindCompanyTypeById(): void
    {
        $this->companyTypeToZedRequestClientInterfaceMock->expects($this->atLeastOnce())
            ->method('call')
            ->with(
                $this->url,
                $this->companyTypeTransferMock,
            )->willReturn($this->companyTypeResponseTransferMock);

        $this->assertInstanceOf(
            CompanyTypeResponseTransfer::class,
            $this->companyTypeStub->findCompanyTypeById(
                $this->companyTypeTransferMock,
            ),
        );
    }
}
