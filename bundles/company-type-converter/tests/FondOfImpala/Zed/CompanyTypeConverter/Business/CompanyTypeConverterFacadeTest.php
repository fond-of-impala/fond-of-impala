<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyReaderInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyTypeConverterInterface;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;

class CompanyTypeConverterFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyTypeConverter\Business\CompanyTypeConverterFacade
     */
    protected $companyTypeConverterFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyResponseTransfer
     */
    protected $companyResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyReaderInterface
     */
    protected $companyReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeConverter\Business\CompanyTypeConverterBusinessFactory
     */
    protected $companyTypeConverterBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyTypeConverterInterface
     */
    protected $companyTypeConverterMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyResponseTransfer
     */
    protected $companyTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyTypeConverterBusinessFactoryMock = $this->getMockBuilder(CompanyTypeConverterBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyResponseTransferMock = $this->getMockBuilder(CompanyResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeConverterMock = $this->getMockBuilder(CompanyTypeConverterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyReaderMock = $this->getMockBuilder(CompanyReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeConverterFacade = new CompanyTypeConverterFacade();
        $this->companyTypeConverterFacade->setFactory($this->companyTypeConverterBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testConvertCompanyType(): void
    {
        $this->companyTypeConverterBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyTypeConverter')
            ->willReturn($this->companyTypeConverterMock);

        $this->companyTypeConverterMock->expects($this->atLeastOnce())
            ->method('convertCompanyType')
            ->with($this->companyTransferMock)
            ->willReturn($this->companyResponseTransferMock);

        $companyResponseTransfer = $this->companyTypeConverterFacade->convertCompanyType(
            $this->companyTransferMock,
        );

        $this->assertEquals(
            $this->companyResponseTransferMock,
            $companyResponseTransfer,
        );

        $this->assertInstanceOf(
            CompanyResponseTransfer::class,
            $companyResponseTransfer,
        );
    }

    /**
     * @return void
     */
    public function testFindCompanyById(): void
    {
        $this->companyTypeConverterBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyReader')
            ->willReturn($this->companyReaderMock);

        $this->companyReaderMock->expects($this->atLeastOnce())
            ->method('findCompanyById')
            ->willReturn($this->companyTransferMock);

        $companyTransfer = $this->companyTypeConverterFacade->findCompanyById($this->companyTransferMock);

        $this->assertEquals(
            $this->companyTransferMock,
            $companyTransfer,
        );

        $this->assertInstanceOf(
            CompanyTransfer::class,
            $companyTransfer,
        );
    }
}
