<?php

namespace FondOfImpala\Zed\CompanyType\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyType\Persistence\CompanyTypeEntityManagerInterface;
use Generated\Shared\Transfer\CompanyTypeTransfer;

class CompanyTypeWriterTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyType\Persistence\CompanyTypeEntityManagerInterface
     */
    protected $companyTypeEntityManagerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTypeTransfer
     */
    protected $companyTypeTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyType\Business\Model\CompanyTypeWriter
     */
    protected $companyTypeWriter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyTypeEntityManagerMock = $this->getMockBuilder(CompanyTypeEntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeTransferMock = $this->getMockBuilder(CompanyTypeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeWriter = new CompanyTypeWriter($this->companyTypeEntityManagerMock);
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->companyTypeEntityManagerMock->expects($this->atLeastOnce())
            ->method('persist')
            ->with($this->companyTypeTransferMock)
            ->willReturn($this->companyTypeTransferMock);

        $this->assertEquals(
            $this->companyTypeTransferMock,
            $this->companyTypeWriter->create($this->companyTypeTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('requireIdCompanyType')
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTypeEntityManagerMock->expects($this->atLeastOnce())
            ->method('persist')
            ->with($this->companyTypeTransferMock)
            ->willReturn($this->companyTypeTransferMock);

        $this->assertEquals(
            $this->companyTypeTransferMock,
            $this->companyTypeWriter->update($this->companyTypeTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testDeleteById(): void
    {
        $idCompanyType = 1;

        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('requireIdCompanyType')
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompanyType')
            ->willReturn($idCompanyType);

        $this->companyTypeEntityManagerMock->expects($this->atLeastOnce())
            ->method('deleteById')
            ->with($idCompanyType);

        $this->companyTypeWriter->deleteById($this->companyTypeTransferMock);
    }
}
