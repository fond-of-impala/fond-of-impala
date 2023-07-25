<?php

namespace FondOfImpala\Zed\CompanyType\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyType\Business\Model\CompanyTypeReaderInterface;
use FondOfImpala\Zed\CompanyType\Business\Model\CompanyTypeWriterInterface;
use Generated\Shared\Transfer\CompanyTypeCollectionTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

class CompanyTypeFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyType\Business\CompanyTypeFacade
     */
    protected $companyTypeFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTypeTransfer
     */
    protected $companyTypeTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyType\Business\CompanyTypeBusinessFactory
     */
    protected $companyTypeBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyType\Business\Model\CompanyTypeReaderInterface
     */
    protected $companyTypeReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTypeCollectionTransfer
     */
    protected $companyTypeCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyType\Business\Model\CompanyTypeWriterInterface
     */
    protected $companyTypeWriterMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyTypeBusinessFactoryMock = $this->getMockBuilder(CompanyTypeBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeTransferMock = $this->getMockBuilder(CompanyTypeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeCollectionTransferMock = $this->getMockBuilder(CompanyTypeCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeReaderMock = $this->getMockBuilder(CompanyTypeReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeWriterMock = $this->getMockBuilder(CompanyTypeWriterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeFacade = new CompanyTypeFacade();

        $this->companyTypeFacade->setFactory($this->companyTypeBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testGetCompanyTypeById(): void
    {
        $this->companyTypeBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyTypeReader')
            ->willReturn($this->companyTypeReaderMock);

        $this->companyTypeReaderMock->expects($this->atLeastOnce())
            ->method('getById')
            ->with($this->companyTypeTransferMock)
            ->willReturn($this->companyTypeTransferMock);

        $this->assertEquals(
            $this->companyTypeTransferMock,
            $this->companyTypeFacade->getCompanyTypeById($this->companyTypeTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testGetCompanyTypes(): void
    {
        $this->companyTypeBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyTypeReader')
            ->willReturn($this->companyTypeReaderMock);

        $this->companyTypeReaderMock->expects($this->atLeastOnce())
            ->method('getAll')
            ->willReturn($this->companyTypeCollectionTransferMock);

        $this->assertEquals(
            $this->companyTypeCollectionTransferMock,
            $this->companyTypeFacade->getCompanyTypes(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyType(): void
    {
        $this->companyTypeBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyTypeWriter')
            ->willReturn($this->companyTypeWriterMock);

        $this->companyTypeWriterMock->expects($this->atLeastOnce())
            ->method('create')
            ->willReturn($this->companyTypeTransferMock);

        $this->assertEquals(
            $this->companyTypeTransferMock,
            $this->companyTypeFacade->createCompanyType($this->companyTypeTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testUpdateCompanyType(): void
    {
        $this->companyTypeBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyTypeWriter')
            ->willReturn($this->companyTypeWriterMock);

        $this->companyTypeWriterMock->expects($this->atLeastOnce())
            ->method('update')
            ->willReturn($this->companyTypeTransferMock);

        $this->assertEquals(
            $this->companyTypeTransferMock,
            $this->companyTypeFacade->updateCompanyType($this->companyTypeTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testDeleteCompanyType(): void
    {
        $this->companyTypeBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyTypeWriter')
            ->willReturn($this->companyTypeWriterMock);

        $this->companyTypeWriterMock->expects($this->atLeastOnce())
            ->method('deleteById');

        $this->companyTypeFacade->deleteCompanyType($this->companyTypeTransferMock);
    }

    /**
     * @return void
     */
    public function testGetCompanyTypeManufacturer(): void
    {
        $this->companyTypeBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyTypeReader')
            ->willReturn($this->companyTypeReaderMock);

        $this->companyTypeReaderMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeManufacturer')
            ->willReturn($this->companyTypeTransferMock);

        $this->assertEquals(
            $this->companyTypeTransferMock,
            $this->companyTypeFacade->getCompanyTypeManufacturer(),
        );
    }
}
