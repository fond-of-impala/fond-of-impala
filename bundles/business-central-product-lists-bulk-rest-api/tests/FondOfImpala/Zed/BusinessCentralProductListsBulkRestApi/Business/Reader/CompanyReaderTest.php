<?php

namespace FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Persistence\BusinessCentralProductListsBulkRestApiRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyReaderTest extends Unit
{
    protected MockObject|BusinessCentralProductListsBulkRestApiRepositoryInterface $repositoryMock;

    protected CompanyReader $companyReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this->getMockBuilder(BusinessCentralProductListsBulkRestApiRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyReader = new CompanyReader(
            $this->repositoryMock,
        );
    }

    /**
     * @return void
     */
    public function testGetIdsByCustomerReferenceAndGroupedIdentifier(): void
    {
        $customerReference = 'FOO--1';
        $groupedIdentifiers = [
            'debtorNumber' => [
                '12345',
                '23456',
            ],
        ];
        $companyIds = [1, 5];

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyIdsByCustomerReferenceAndDebtorNumbers')
            ->with($customerReference, $groupedIdentifiers['debtorNumber'])
            ->willReturn($companyIds);

        static::assertEquals(
            $companyIds,
            $this->companyReader->getIdsByCustomerReferenceAndGroupedIdentifier($customerReference, $groupedIdentifiers),
        );
    }

    /**
     * @return void
     */
    public function testGetIdsByCustomerReferenceAndGroupedIdentifierWithoutDebtorNumbers(): void
    {
        $customerReference = 'FOO--1';
        $groupedIdentifiers = [
            'debtorNumber' => [],
        ];
        $companyIds = [];

        $this->repositoryMock->expects(static::never())
            ->method('getCompanyIdsByCustomerReferenceAndDebtorNumbers');

        static::assertEquals(
            $companyIds,
            $this->companyReader->getIdsByCustomerReferenceAndGroupedIdentifier($customerReference, $groupedIdentifiers),
        );
    }

    /**
     * @return void
     */
    public function testGetIdsByCustomerReferenceAndUuids(): void
    {
        $customerReference = 'FOO--1';
        $debtorNumbers = [
            '12345',
            '23456',
        ];
        $companyIds = [1, 5];

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyIdsByCustomerReferenceAndDebtorNumbers')
            ->with($customerReference, $debtorNumbers)
            ->willReturn($companyIds);

        static::assertEquals(
            $companyIds,
            $this->companyReader->getIdsByCustomerReferenceAndDebtorNumbers($customerReference, $debtorNumbers),
        );
    }
}
