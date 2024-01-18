<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Dependency\Facade\CompanyBusinessUnitsCartsRestApiToCompanyBusinessUnitFacadeInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitResponseTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer;

class CompanyBusinessUnitReaderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Dependency\Facade\CompanyBusinessUnitsCartsRestApiToCompanyBusinessUnitFacadeInterface
     */
    protected $companyBusinessUnitFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer
     */
    protected $restCompanyBusinessUnitCartListTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitResponseTransfer
     */
    protected $companyBusinessUnitResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitResponseTransfer
     */
    protected $companyBusinessUnitTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business\Model\CompanyBusinessUnitReader
     */
    protected $companyBusinessUnitReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyBusinessUnitFacadeMock = $this->getMockBuilder(CompanyBusinessUnitsCartsRestApiToCompanyBusinessUnitFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyBusinessUnitCartListTransferMock = $this->getMockBuilder(RestCompanyBusinessUnitCartListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitResponseTransferMock = $this->getMockBuilder(CompanyBusinessUnitResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitTransferMock = $this->getMockBuilder(CompanyBusinessUnitTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitReader = new CompanyBusinessUnitReader(
            $this->companyBusinessUnitFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetByRestCompanyBusinessUnitCartList(): void
    {
        $companyBusinessUnitUuid = '90cc61b2-0178-11eb-adc1-0242ac120002';

        $this->restCompanyBusinessUnitCartListTransferMock->expects(self::atLeastOnce())
            ->method('getCompanyBusinessUnitUuid')
            ->willReturn($companyBusinessUnitUuid);

        $this->companyBusinessUnitFacadeMock->expects(self::atLeastOnce())
            ->method('findCompanyBusinessUnitByUuid')
            ->willReturn($this->companyBusinessUnitResponseTransferMock);

        $this->companyBusinessUnitResponseTransferMock->expects(self::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyBusinessUnitResponseTransferMock->expects(self::atLeastOnce())
            ->method('getCompanyBusinessUnitTransfer')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $companyBusinessUnitTransfer = $this->companyBusinessUnitReader->getByRestCompanyBusinessUnitCartList(
            $this->restCompanyBusinessUnitCartListTransferMock,
        );

        self::assertEquals(
            $this->companyBusinessUnitTransferMock,
            $companyBusinessUnitTransfer,
        );
    }

    /**
     * @return void
     */
    public function testGetByRestCompanyBusinessUnitCartListWithoutCompanyBusinessUnitUuid(): void
    {
        $this->restCompanyBusinessUnitCartListTransferMock->expects(self::atLeastOnce())
            ->method('getCompanyBusinessUnitUuid')
            ->willReturn(null);

        $this->companyBusinessUnitFacadeMock->expects(self::never())
            ->method('findCompanyBusinessUnitByUuid');

        $this->companyBusinessUnitResponseTransferMock->expects(self::never())
            ->method('getIsSuccessful');

        $this->companyBusinessUnitResponseTransferMock->expects(self::never())
            ->method('getCompanyBusinessUnitTransfer');

        $companyBusinessUnitTransfer = $this->companyBusinessUnitReader->getByRestCompanyBusinessUnitCartList(
            $this->restCompanyBusinessUnitCartListTransferMock,
        );

        self::assertEquals(
            null,
            $companyBusinessUnitTransfer,
        );
    }

    /**
     * @return void
     */
    public function testGetByRestCompanyBusinessUnitCartListWithNotExistingCompanyBusinessUnitUuid(): void
    {
        $companyBusinessUnitUuid = '90cc61b2-0178-11eb-adc1-0242ac120002';

        $this->restCompanyBusinessUnitCartListTransferMock->expects(self::atLeastOnce())
            ->method('getCompanyBusinessUnitUuid')
            ->willReturn($companyBusinessUnitUuid);

        $this->companyBusinessUnitFacadeMock->expects(self::atLeastOnce())
            ->method('findCompanyBusinessUnitByUuid')
            ->willReturn($this->companyBusinessUnitResponseTransferMock);

        $this->companyBusinessUnitResponseTransferMock->expects(self::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        $this->companyBusinessUnitResponseTransferMock->expects(self::never())
            ->method('getCompanyBusinessUnitTransfer');

        $companyBusinessUnitTransfer = $this->companyBusinessUnitReader->getByRestCompanyBusinessUnitCartList(
            $this->restCompanyBusinessUnitCartListTransferMock,
        );

        self::assertEquals(
            null,
            $companyBusinessUnitTransfer,
        );
    }
}
