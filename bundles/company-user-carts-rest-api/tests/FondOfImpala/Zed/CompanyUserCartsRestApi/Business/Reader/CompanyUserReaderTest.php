<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToCompanyUserReferenceFacadeInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyUserReaderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToCompanyUserReferenceFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CompanyUserCartsRestApiToCompanyUserReferenceFacadeInterface $companyUserReferenceFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CompanyUserTransfer $companyUserTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CompanyUserResponseTransfer $companyUserResponseTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader\CompanyUserReader
     */
    protected CompanyUserReader $companyUserReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyUserReferenceFacadeMock = $this->getMockBuilder(CompanyUserCartsRestApiToCompanyUserReferenceFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUserCartsRequestTransferMock = $this->getMockBuilder(RestCompanyUserCartsRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReader = new CompanyUserReader(
            $this->companyUserReferenceFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetByRestCompanyUserCartsRequest(): void
    {
        $idCustomer = 1;
        $companyUserReference = 'FOO--CU-1';

        $this->restCompanyUserCartsRequestTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($idCustomer);

        $this->restCompanyUserCartsRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($companyUserReference);

        $this->companyUserReferenceFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->with(
                static::callback(
                    static function (CompanyUserTransfer $companyUserTransfer) use ($companyUserReference) {
                        return $companyUserTransfer->getCompanyUserReference() === $companyUserReference;
                    },
                ),
            )->willReturn(
                $this->companyUserResponseTransferMock,
            );

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getFkCustomer')
            ->willReturn($idCustomer);

        static::assertEquals(
            $this->companyUserTransferMock,
            $this->companyUserReader->getByRestCompanyUserCartsRequest($this->restCompanyUserCartsRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testGetByRestCompanyUserCartsRequestWithInvalidData(): void
    {
        $idCustomer = null;
        $companyUserReference = 'FOO--CU-1';

        $this->restCompanyUserCartsRequestTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($idCustomer);

        $this->restCompanyUserCartsRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($companyUserReference);

        $this->companyUserReferenceFacadeMock->expects(static::never())
            ->method('findCompanyUserByCompanyUserReference');

        static::assertEquals(
            null,
            $this->companyUserReader->getByRestCompanyUserCartsRequest($this->restCompanyUserCartsRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testGetByRestCompanyUserCartsRequestWithoutResult(): void
    {
        $idCustomer = 1;
        $companyUserReference = 'FOO--CU-1';

        $this->restCompanyUserCartsRequestTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($idCustomer);

        $this->restCompanyUserCartsRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($companyUserReference);

        $this->companyUserReferenceFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->with(
                static::callback(
                    static function (CompanyUserTransfer $companyUserTransfer) use ($companyUserReference) {
                        return $companyUserTransfer->getCompanyUserReference() === $companyUserReference;
                    },
                ),
            )->willReturn(
                $this->companyUserResponseTransferMock,
            );

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn(null);

        $this->companyUserResponseTransferMock->expects(static::never())
            ->method('getIsSuccessful');

        static::assertEquals(
            null,
            $this->companyUserReader->getByRestCompanyUserCartsRequest($this->restCompanyUserCartsRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testGetIdByRestCompanyUserCartsRequest(): void
    {
        $idCustomer = 1;
        $companyUserReference = 'FOO--CU-1';
        $idCompanyUser = 3;

        $this->restCompanyUserCartsRequestTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($idCustomer);

        $this->restCompanyUserCartsRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($companyUserReference);

        $this->companyUserReferenceFacadeMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUserByCompanyUserReferenceAndIdCustomer')
            ->with(
                $companyUserReference,
                $idCustomer,
            )->willReturn($idCompanyUser);

        static::assertEquals(
            $idCompanyUser,
            $this->companyUserReader->getIdByRestCompanyUserCartsRequest($this->restCompanyUserCartsRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testGetIdByRestCompanyUserCartsRequestWithInvalidData(): void
    {
        $idCustomer = null;
        $companyUserReference = 'FOO--CU-1';

        $this->restCompanyUserCartsRequestTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($idCustomer);

        $this->restCompanyUserCartsRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($companyUserReference);

        $this->companyUserReferenceFacadeMock->expects(static::never())
            ->method('getIdCompanyUserByCompanyUserReferenceAndIdCustomer');

        static::assertEquals(
            null,
            $this->companyUserReader->getIdByRestCompanyUserCartsRequest($this->restCompanyUserCartsRequestTransferMock),
        );
    }
}
