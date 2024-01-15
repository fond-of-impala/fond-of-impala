<?php

namespace FondOfImpala\Zed\CompanyUserReference\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserReference\Business\Generator\CompanyUserReferenceGeneratorInterface;
use FondOfImpala\Zed\CompanyUserReference\Business\Reader\CompanyBusinessUnitReaderInterface;
use FondOfImpala\Zed\CompanyUserReference\Business\Reader\CompanyReaderInterface;
use FondOfImpala\Zed\CompanyUserReference\Business\Reader\CompanyUserReaderInterface;
use FondOfImpala\Zed\CompanyUserReference\Persistence\CompanyUserReferenceRepository;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyUserReferenceFacadeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserReference\Business\CompanyUserReferenceBusinessFactory
     */
    protected $factoryMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\Persistence\CompanyUserReferenceRepository|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CompanyUserReferenceRepository $repositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserReference\Business\Generator\CompanyUserReferenceGeneratorInterface
     */
    protected CompanyUserReferenceGeneratorInterface|MockObject $companyUserReferenceGeneratorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected MockObject|CompanyUserTransfer $companyUserTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserReference\Business\Reader\CompanyUserReaderInterface
     */
    protected CompanyUserReaderInterface|MockObject $companyUserReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    protected MockObject|CompanyUserResponseTransfer $companyUserResponseTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\Business\Reader\CompanyReaderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CompanyReaderInterface $companyReaderMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CompanyTransfer $companyTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\Business\Reader\CompanyBusinessUnitReaderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyBusinessUnitReaderInterface|MockObject $companyBusinessUnitReaderMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyBusinessUnitTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyBusinessUnitTransfer|MockObject $companyBusinessUnitTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\Business\CompanyUserReferenceFacade
     */
    protected CompanyUserReferenceFacade $companyUserReferenceFacade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->factoryMock = $this->getMockBuilder(CompanyUserReferenceBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(CompanyUserReferenceRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReferenceGeneratorMock = $this->getMockBuilder(CompanyUserReferenceGeneratorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReaderMock = $this->getMockBuilder(CompanyUserReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyReaderMock = $this->getMockBuilder(CompanyReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitReaderMock = $this->getMockBuilder(CompanyBusinessUnitReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitTransferMock = $this->getMockBuilder(CompanyBusinessUnitTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReferenceFacade = new CompanyUserReferenceFacade();
        $this->companyUserReferenceFacade->setFactory($this->factoryMock);
        $this->companyUserReferenceFacade->setRepository($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testGenerateCompanyUserReference(): void
    {
        $companyUserReference = 'FOO--CU-1';

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyUserReferenceGenerator')
            ->willReturn($this->companyUserReferenceGeneratorMock);

        $this->companyUserReferenceGeneratorMock->expects(static::atLeastOnce())
            ->method('generate')
            ->willReturn($companyUserReference);

        static::assertEquals(
            $companyUserReference,
            $this->companyUserReferenceFacade->generateCompanyUserReference(),
        );
    }

    /**
     * @return void
     */
    public function testFindCompanyUserByCompanyUserReference(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyUserReader')
            ->willReturn($this->companyUserReaderMock);

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->companyUserResponseTransferMock);

        static::assertEquals(
            $this->companyUserResponseTransferMock,
            $this->companyUserReferenceFacade->findCompanyUserByCompanyUserReference(
                $this->companyUserTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetCompanyByCompanyUserReference(): void
    {
        $companyUserReference = 'FOO--CU-1';

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyReader')
            ->willReturn($this->companyReaderMock);

        $this->companyReaderMock->expects(static::atLeastOnce())
            ->method('getByCompanyUserReference')
            ->with($companyUserReference)
            ->willReturn($this->companyTransferMock);

        static::assertEquals(
            $this->companyTransferMock,
            $this->companyUserReferenceFacade->getCompanyByCompanyUserReference(
                $companyUserReference,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetCompanyBusinessUnitByCompanyUserReference(): void
    {
        $companyUserReference = 'FOO--CU-1';

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyBusinessUnitReader')
            ->willReturn($this->companyBusinessUnitReaderMock);

        $this->companyBusinessUnitReaderMock->expects(static::atLeastOnce())
            ->method('getByCompanyUserReference')
            ->with($companyUserReference)
            ->willReturn($this->companyBusinessUnitTransferMock);

        static::assertEquals(
            $this->companyBusinessUnitTransferMock,
            $this->companyUserReferenceFacade->getCompanyBusinessUnitByCompanyUserReference(
                $companyUserReference,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetIdCompanyUserByCompanyUserReferenceAndIdCustomer(): void
    {
        $companyUserReference = 'foo';
        $idCustomer = 1;
        $idCompanyUser = 3;

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findIdCompanyUserByCompanyUserReferenceAndFkCustomer')
            ->with($companyUserReference, $idCustomer)
            ->willReturn($idCompanyUser);

        static::assertEquals(
            $idCompanyUser,
            $this->companyUserReferenceFacade->getIdCompanyUserByCompanyUserReferenceAndIdCustomer(
                $companyUserReference,
                $idCustomer,
            ),
        );
    }
}
