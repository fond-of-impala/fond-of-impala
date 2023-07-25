<?php

namespace FondOfImpala\Zed\CompanyType\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyType\CompanyTypeConfig;
use FondOfImpala\Zed\CompanyType\Persistence\CompanyTypeRepositoryInterface;
use Generated\Shared\Transfer\CompanyTypeCollectionTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

class CompanyTypeReaderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyType\CompanyTypeConfig
     */
    protected $companyTypeConfigMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyType\Persistence\CompanyTypeRepositoryInterface
     */
    protected $companyTypeRepositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTypeTransfer
     */
    protected $companyTypeTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTypeCollectionTransfer
     */
    protected $companyTypeCollectionTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyType\Business\Model\CompanyTypeReader
     */
    protected $companyTypeReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyTypeConfigMock = $this->getMockBuilder(CompanyTypeConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeRepositoryMock = $this->getMockBuilder(CompanyTypeRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeTransferMock = $this->getMockBuilder(CompanyTypeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeCollectionTransferMock = $this->getMockBuilder(CompanyTypeCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeReader = new CompanyTypeReader(
            $this->companyTypeRepositoryMock,
            $this->companyTypeConfigMock,
        );
    }

    /**
     * @return void
     */
    public function testGetById(): void
    {
        $idCompanyType = 1;

        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('requireIdCompanyType')
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompanyType')
            ->willReturn($idCompanyType);

        $this->companyTypeRepositoryMock->expects($this->atLeastOnce())
            ->method('getById')
            ->with($idCompanyType)
            ->willReturn($this->companyTypeTransferMock);

        $this->assertEquals(
            $this->companyTypeTransferMock,
            $this->companyTypeReader->getById($this->companyTypeTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testGetAll(): void
    {
        $this->companyTypeRepositoryMock->expects($this->atLeastOnce())
            ->method('getAll')
            ->willReturn($this->companyTypeCollectionTransferMock);

        $this->assertEquals(
            $this->companyTypeCollectionTransferMock,
            $this->companyTypeReader->getAll(),
        );
    }

    /**
     * @return void
     */
    public function testGetCompanyTypeManufacturer(): void
    {
        $name = 'manufacturer';
        $this->companyTypeConfigMock->expects(static::atLeastOnce())
            ->method('getCompanyTypeManufacturer')
            ->willReturn($name);

        $this->companyTypeRepositoryMock->expects(static::atLeastOnce())
            ->method('getByName')
            ->with($name)
            ->willReturn($this->companyTypeTransferMock);

        $this->assertEquals(
            $this->companyTypeTransferMock,
            $this->companyTypeReader->getCompanyTypeManufacturer(),
        );
    }
}
