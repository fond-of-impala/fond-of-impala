<?php

namespace FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Reader;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Filter\CompanyUuidFilterInterface;
use FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Filter\IdCustomerFilterInterface;
use FondOfImpala\Zed\CompanyCartSearchRestApi\Persistence\CompanyCartSearchRestApiRepositoryInterface;
use Generated\Shared\Transfer\FilterFieldTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyReaderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Filter\IdCustomerFilterInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|IdCustomerFilterInterface $idCustomerFilterMock;

    /**
     * @var \FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Filter\CompanyUuidFilterInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CompanyUuidFilterInterface $companyUuidFilterMock;

    /**
     * @var \FondOfImpala\Zed\CompanyCartSearchRestApi\Persistence\CompanyCartSearchRestApiRepositoryInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CompanyCartSearchRestApiRepositoryInterface $repositoryMock;

    /**
     * @var array<\Generated\Shared\Transfer\FilterFieldTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $filterFieldTransferMocks;

    /**
     * @var \FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Reader\CompanyReader
     */
    protected CompanyReader $companyReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->idCustomerFilterMock = $this->getMockBuilder(IdCustomerFilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUuidFilterMock = $this->getMockBuilder(CompanyUuidFilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(CompanyCartSearchRestApiRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->filterFieldTransferMocks = [
            $this->getMockBuilder(FilterFieldTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(FilterFieldTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->companyReader = new CompanyReader(
            $this->idCustomerFilterMock,
            $this->companyUuidFilterMock,
            $this->repositoryMock,
        );
    }

    /**
     * @return void
     */
    public function testGetIdByFilterFields(): void
    {
        $self = $this;
        $idCompany = 1;
        $idCustomer = 1;
        $companyUuid = 'd5ffcf7e-183f-4aa1-819e-74acf9f6a134';

        $this->idCustomerFilterMock->expects($this->atLeastOnce())
            ->method('filterByFilterField')
            ->willReturnCallback(static function (FilterFieldTransfer $filterFieldTransfer) use ($self, $idCustomer) {
                if ($filterFieldTransfer === $self->filterFieldTransferMocks[0]) {
                    return $idCustomer;
                }

                if ($filterFieldTransfer === $self->filterFieldTransferMocks[1]) {
                    return null;
                }

                throw new Exception('Unexpected call');
            });

        $this->companyUuidFilterMock->expects(static::atLeastOnce())
            ->method('filterByFilterField')
            ->with($this->filterFieldTransferMocks[0])
            ->willReturn($companyUuid);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getIdCompanyByIdCustomerAndCompanyUuid')
            ->with(
                $idCustomer,
                $companyUuid,
            )->willReturn($idCompany);

        static::assertEquals(
            $idCompany,
            $this->companyReader->getIdByFilterFields($this->filterFieldTransferMocks),
        );
    }

    /**
     * @return void
     */
    public function testGetIdByFilterFieldsWithInvalidFilterFields(): void
    {
        $self = $this;
        $idCustomer = 1;

        $this->idCustomerFilterMock->expects($this->atLeastOnce())
            ->method('filterByFilterField')
            ->willReturnCallback(static function (FilterFieldTransfer $filterFieldTransfer) use ($self, $idCustomer) {
                if ($filterFieldTransfer === $self->filterFieldTransferMocks[0]) {
                    return $idCustomer;
                }

                if ($filterFieldTransfer === $self->filterFieldTransferMocks[1]) {
                    return null;
                }

                throw new Exception('Unexpected call');
            });

        $this->companyUuidFilterMock->expects(static::atLeastOnce())
            ->method('filterByFilterField')
            ->with($this->filterFieldTransferMocks[0])
            ->willReturn(null);

        $this->repositoryMock->expects(static::never())
            ->method('getIdCompanyByIdCustomerAndCompanyUuid');

        static::assertEquals(
            null,
            $this->companyReader->getIdByFilterFields($this->filterFieldTransferMocks),
        );
    }
}
