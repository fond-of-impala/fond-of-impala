<?php

namespace FondOfImpala\Zed\CompanyCompanyTypeGui\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyType\Business\CompanyTypeFacadeInterface;
use Generated\Shared\Transfer\CompanyTypeCollectionTransfer;

class CompanyCompanyTypeGuiToCompanyTypeFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyTypeCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyType\Business\CompanyTypeFacadeInterface
     */
    protected $companyTypeFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyCompanyTypeGui\Dependency\Facade\CompanyCompanyTypeGuiToCompanyTypeFacadeBridge
     */
    protected $companyCompanyTypeGuiToCompanyTypeFacadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyTypeCollectionTransferMock = $this->getMockBuilder(CompanyTypeCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeFacadeMock = $this->getMockBuilder(CompanyTypeFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyCompanyTypeGuiToCompanyTypeFacadeBridge = new CompanyCompanyTypeGuiToCompanyTypeFacadeBridge(
            $this->companyTypeFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetCompanyTypes(): void
    {
        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyTypes')
            ->willReturn($this->companyTypeCollectionTransferMock);

        $companyTypeTransferCollection = $this->companyCompanyTypeGuiToCompanyTypeFacadeBridge->getCompanyTypes();

        $this->assertEquals($this->companyTypeCollectionTransferMock, $companyTypeTransferCollection);
    }
}
