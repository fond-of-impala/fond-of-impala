<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Writer;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator\RandomPasswordGeneratorInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordKeyGeneratorInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordLinkGeneratorInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Mapper\CustomerMapperInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCustomerTransfer;

class CustomerWriterTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\Mapper\CustomerMapperInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $customerMapperMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator\RandomPasswordGeneratorInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $randomPasswordGeneratorMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordKeyGeneratorInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restorePasswordKeyGeneratorMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordLinkGeneratorInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restorePasswordLinkGeneratorMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $customerFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\RestCustomerTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCustomerTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CustomerResponseTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $customerResponseTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $customerTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\Writer\CustomerWriter
     */
    protected $customerWriter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->customerMapperMock = $this->getMockBuilder(CustomerMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->randomPasswordGeneratorMock = $this->getMockBuilder(RandomPasswordGeneratorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restorePasswordKeyGeneratorMock = $this->getMockBuilder(RestorePasswordKeyGeneratorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restorePasswordLinkGeneratorMock = $this->getMockBuilder(RestorePasswordLinkGeneratorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToCustomerFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCustomerTransferMock = $this->getMockBuilder(RestCustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerResponseTransferMock = $this->getMockBuilder(CustomerResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerWriter = new CustomerWriter(
            $this->customerMapperMock,
            $this->randomPasswordGeneratorMock,
            $this->restorePasswordKeyGeneratorMock,
            $this->restorePasswordLinkGeneratorMock,
            $this->customerFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testCreateByRestCustomer(): void
    {
        $password = 'foobar';
        $restorePasswordKey = 'foo';
        $restorePasswordLink = 'http://foo.bar/xxx';

        $this->customerMapperMock->expects(static::atLeastOnce())
            ->method('fromRestCustomer')
            ->with($this->restCustomerTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->randomPasswordGeneratorMock->expects(static::atLeastOnce())
            ->method('generate')
            ->willReturn($password);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setPassword')
            ->with($password)
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setRestorePasswordDate')
            ->willReturn($this->customerTransferMock);

        $this->restorePasswordKeyGeneratorMock->expects(static::atLeastOnce())
            ->method('generate')
            ->willReturn($restorePasswordKey);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setRestorePasswordKey')
            ->with($restorePasswordKey)
            ->willReturn($this->customerTransferMock);

        $this->restorePasswordLinkGeneratorMock->expects(static::atLeastOnce())
            ->method('generate')
            ->with($restorePasswordKey)
            ->willReturn($restorePasswordLink);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setRestorePasswordLink')
            ->with($restorePasswordLink)
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setIsNew')
            ->with(true)
            ->willReturn($this->customerTransferMock);

        $this->customerFacadeMock->expects(static::atLeastOnce())
            ->method('addCustomer')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerResponseTransferMock);

        $this->customerResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerTransfer')
            ->willReturn($this->customerTransferMock);

        $this->customerResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(true);

        static::assertEquals(
            $this->customerTransferMock,
            $this->customerWriter->createByRestCustomer($this->restCustomerTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testCreateByRestCustomerWithInvalidData(): void
    {
        $password = 'foobar';
        $restorePasswordKey = 'foo';
        $restorePasswordLink = 'http://foo.bar/xxx';

        $this->customerMapperMock->expects(static::atLeastOnce())
            ->method('fromRestCustomer')
            ->with($this->restCustomerTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->randomPasswordGeneratorMock->expects(static::atLeastOnce())
            ->method('generate')
            ->willReturn($password);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setPassword')
            ->with($password)
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setRestorePasswordDate')
            ->willReturn($this->customerTransferMock);

        $this->restorePasswordKeyGeneratorMock->expects(static::atLeastOnce())
            ->method('generate')
            ->willReturn($restorePasswordKey);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setRestorePasswordKey')
            ->with($restorePasswordKey)
            ->willReturn($this->customerTransferMock);

        $this->restorePasswordLinkGeneratorMock->expects(static::atLeastOnce())
            ->method('generate')
            ->with($restorePasswordKey)
            ->willReturn($restorePasswordLink);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setRestorePasswordLink')
            ->with($restorePasswordLink)
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setIsNew')
            ->with(true)
            ->willReturn($this->customerTransferMock);

        $this->customerFacadeMock->expects(static::atLeastOnce())
            ->method('addCustomer')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerResponseTransferMock);

        $this->customerResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerTransfer')
            ->willReturn(null);

        $this->customerResponseTransferMock->expects(static::never())
            ->method('getIsSuccess');

        static::assertEquals(
            null,
            $this->customerWriter->createByRestCustomer($this->restCustomerTransferMock),
        );
    }
}
