<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyTypeConverter\CompanyTypeConverterConfig;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeFacadeInterface;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeResponseTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;

class CompanyTypeBlacklistValidatorTest extends Unit
{
    protected CompanyTypeConverterToCompanyTypeFacadeInterface|MockObject $companyTypeFacadeMock;

    protected CompanyTypeConverterConfig|MockObject $configMock;

    protected LoggerInterface|MockObject $loggerMock;

    protected CompanyTransfer|MockObject $companyTransferMock;

    protected CompanyTypeTransfer|MockObject $companyTypeTransferMock;

    protected CompanyTypeResponseTransfer|MockObject $companyTypeResponseTransferMock;

    protected CompanyTypeBlacklistValidator $validator;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyTypeFacadeMock = $this->getMockBuilder(CompanyTypeConverterToCompanyTypeFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(CompanyTypeConverterConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->loggerMock = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeResponseTransferMock = $this->getMockBuilder(CompanyTypeResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeTransferMock = $this->getMockBuilder(CompanyTypeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->validator = new CompanyTypeBlacklistValidator($this->companyTypeFacadeMock, $this->configMock, $this->loggerMock);
    }

    /**
     * @return void
     */
    public function testValidate(): void
    {
        $id1 = 1;
        $id2 = 2;

        $companyTransferMockClone = clone $this->companyTransferMock;

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('requireFkCompanyType')
            ->willReturnSelf();

        $companyTransferMockClone->expects($this->atLeastOnce())
            ->method('requireFkCompanyType')
            ->willReturnSelf();

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn($id1);

        $companyTransferMockClone->expects($this->atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn($id2);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyType')
            ->willReturn($this->companyTypeTransferMock);

        $companyTransferMockClone->expects($this->atLeastOnce())
            ->method('getCompanyType')
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompanyType')
            ->willReturn(1);

        $this->configMock->expects($this->atLeastOnce())
            ->method('getNonConvertibleRoleTypeKeys')
            ->willReturn([]);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyTypeById')
            ->willReturn($this->companyTypeResponseTransferMock);

        $this->companyTypeResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyTypeResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeTransfer')
            ->willReturn($this->companyTypeTransferMock);

        static::assertTrue($this->validator->validate($this->companyTransferMock, $companyTransferMockClone));
    }

    /**
     * @return void
     */
    public function testValidateIsBlacklistedByKey(): void
    {
        $id1 = 1;
        $id2 = 2;
        $type1 = 'manufacturer';
        $type2 = 'retailer';
        $blacklist = [
            $type1 => [$type2],
        ];

        $companyTransferMockClone = clone $this->companyTransferMock;
        $companyTypeTransferMockClone = clone $this->companyTypeTransferMock;

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('requireFkCompanyType')
            ->willReturnSelf();

        $companyTransferMockClone->expects($this->atLeastOnce())
            ->method('requireFkCompanyType')
            ->willReturnSelf();

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn($id1);

        $companyTransferMockClone->expects($this->atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn($id2);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyType')
            ->willReturn($this->companyTypeTransferMock);

        $companyTransferMockClone->expects($this->atLeastOnce())
            ->method('getCompanyType')
            ->willReturn($companyTypeTransferMockClone);

        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompanyType')
            ->willReturn(1);

        $companyTypeTransferMockClone->expects($this->atLeastOnce())
            ->method('getIdCompanyType')
            ->willReturn(2);

        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('getKey')
            ->willReturn($type1);

        $companyTypeTransferMockClone->expects($this->atLeastOnce())
            ->method('getKey')
            ->willReturn($type2);

        $this->configMock->expects($this->atLeastOnce())
            ->method('getNonConvertibleRoleTypeKeys')
            ->willReturn($blacklist);

        static::assertFalse($this->validator->validate($this->companyTransferMock, $companyTransferMockClone));
    }

    /**
     * @return void
     */
    public function testValidateIsBlacklistedByName(): void
    {
        $id1 = 1;
        $id2 = 2;
        $type1 = 'manufacturer';
        $type2 = 'retailer';
        $blacklist = [
            $type1 => [$type2],
        ];

        $companyTransferMockClone = clone $this->companyTransferMock;
        $companyTypeTransferMockClone = clone $this->companyTypeTransferMock;

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('requireFkCompanyType')
            ->willReturnSelf();

        $companyTransferMockClone->expects($this->atLeastOnce())
            ->method('requireFkCompanyType')
            ->willReturnSelf();

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn($id1);

        $companyTransferMockClone->expects($this->atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn($id2);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyType')
            ->willReturn($this->companyTypeTransferMock);

        $companyTransferMockClone->expects($this->atLeastOnce())
            ->method('getCompanyType')
            ->willReturn($companyTypeTransferMockClone);

        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompanyType')
            ->willReturn(1);

        $companyTypeTransferMockClone->expects($this->atLeastOnce())
            ->method('getIdCompanyType')
            ->willReturn(2);

        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($type1);

        $companyTypeTransferMockClone->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($type2);

        $this->configMock->expects($this->atLeastOnce())
            ->method('getNonConvertibleRoleTypeKeys')
            ->willReturn($blacklist);

        static::assertFalse($this->validator->validate($this->companyTransferMock, $companyTransferMockClone));
    }
}
