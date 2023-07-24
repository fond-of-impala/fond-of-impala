<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Business\Model;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyTypeConverter\CompanyTypeConverterConfig;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyRoleFacadeInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeFacadeInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyUserFacadeInterface;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeResponseTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Propel\Runtime\Connection\ConnectionInterface;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionHandlerInterface;

class CompanyTypeConverterTest extends Unit
{
    /**
     * @var \Propel\Runtime\Connection\ConnectionInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $connectionMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeConverter\CompanyTypeConverterConfig
     */
    protected $configMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeFacadeInterface
     */
    protected $companyTypeFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyRoleFacadeInterface
     */
    protected $companyRoleFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyUserFacadeInterface
     */
    protected $companyUserFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyTypeRoleWriterInterface
     */
    protected $companyTypeRoleWriterMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected $companyTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyTypeConverter
     */
    protected $companyTypeConverter;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyTypeConverterPluginExecutorInterface
     */
    protected $companyTypeConverterPluginExecutorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    protected $companyRoleCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    protected $companyUserCompanyRoleCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    protected $companyUserCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleTransfer
     */
    protected $companyRoleTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTypeResponseTransfer
     */
    protected $companyTypeResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTypeTransfer
     */
    protected $companyTypeTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->connectionMock = $this->getMockBuilder(ConnectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(CompanyTypeConverterConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeFacadeMock = $this->getMockBuilder(CompanyTypeConverterToCompanyTypeFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleFacadeMock = $this->getMockBuilder(CompanyTypeConverterToCompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserFacadeMock = $this->getMockBuilder(CompanyTypeConverterToCompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeRoleWriterMock = $this->getMockBuilder(CompanyTypeRoleWriterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeConverterPluginExecutorMock = $this->getMockBuilder(CompanyTypeConverterPluginExecutorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCompanyRoleCollectionTransferMock = $this->getMockBuilder(CompanyRoleCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleCollectionTransferMock = $this->getMockBuilder(CompanyRoleCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserRoleTransferMock = $this->getMockBuilder(CompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleTransferMock = $this->getMockBuilder(CompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeResponseTransferMock = $this->getMockBuilder(CompanyTypeResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCollectionTransferMock = $this->getMockBuilder(CompanyUserCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeTransferMock = $this->getMockBuilder(CompanyTypeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeConverter = new class (
            $this->companyTypeFacadeMock,
            $this->companyRoleFacadeMock,
            $this->companyUserFacadeMock,
            $this->companyTypeRoleWriterMock,
            $this->configMock,
            $this->companyTypeConverterPluginExecutorMock
        ) extends CompanyTypeConverter {
            /**
             * @var \Spryker\Zed\Kernel\Persistence\EntityManager\TransactionHandlerInterface
             */
            protected $transactionHandler;

            /**
             * @return \Spryker\Zed\Kernel\Persistence\EntityManager\TransactionHandlerInterface
             */
            public function getTransactionHandler(): TransactionHandlerInterface
            {
                if ($this->transactionHandler === null) {
                    $this->transactionHandler = parent::getTransactionHandler();
                }

                return $this->transactionHandler;
            }
        };

        $this->companyTypeConverter->getTransactionHandler()
            ->setConnection($this->connectionMock);
    }

    /**
     * @return void
     */
    public function testConvertCompanyType(): void
    {
        $companyUsers = new ArrayObject();
        $companyUsers->append($this->companyUserTransferMock);
        $companyUserRoles = new ArrayObject();
        $companyUserRoles->append($this->companyUserRoleTransferMock);
        $companyRoles = new ArrayObject();
        $companyRoles->append($this->companyRoleTransferMock);
        $defaultRoleMapping = [
            'role' => 'default_role',
        ];

        $this->companyTypeConverterPluginExecutorMock->expects($this->atLeastOnce())
            ->method('executeCompanyTypeConverterPreSavePlugins')
            ->with($this->companyTransferMock)
            ->willReturn($this->companyTransferMock);

        $this->companyTypeRoleWriterMock->expects($this->atLeastOnce())
            ->method('updateCompanyRoles')
            ->with($this->companyTransferMock)
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->companyUserFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyUserCollection')
            ->willReturn($this->companyUserCollectionTransferMock);

        $this->companyUserCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUsers')
            ->willReturn($companyUsers);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyTypeById')
            ->willReturn($this->companyTypeResponseTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->willReturn($this->companyUserCompanyRoleCollectionTransferMock);

        $this->companyUserCompanyRoleCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getRoles')
            ->willReturn($companyUserRoles);

        $this->companyUserRoleTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn('role');

        $this->configMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeDefaultRoleMapping')
            ->willReturn($defaultRoleMapping);

        $this->companyRoleCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getRoles')
            ->willReturn($companyRoles);

        $this->companyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn('default_role');

        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn('company_type');

        $this->companyTypeResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeTransfer')
            ->willReturn($this->companyTypeTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setCompanyRoleCollection')
            ->willReturn($this->companyUserTransferMock);

        $this->companyTypeConverterPluginExecutorMock->expects($this->atLeastOnce())
            ->method('executeCompanyTypeConverterPostSavePlugins')
            ->with($this->companyTransferMock)
            ->willReturn($this->companyTransferMock);

        $companyResponseTransfer = $this->companyTypeConverter->convertCompanyType($this->companyTransferMock);

        $this->assertInstanceOf(
            CompanyResponseTransfer::class,
            $companyResponseTransfer,
        );

        $this->assertEquals(true, $companyResponseTransfer->getIsSuccessful());
        $this->assertInstanceOf(
            CompanyTransfer::class,
            $companyResponseTransfer->getCompanyTransfer(),
        );
    }
}
