<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Persistence\CompanyProductListsBulkRestApiRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyReaderTest extends Unit
{
    protected MockObject|CompanyProductListsBulkRestApiRepositoryInterface $repositoryMock;

    protected CompanyReader $companyReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this->getMockBuilder(CompanyProductListsBulkRestApiRepositoryInterface::class)
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
            'uuid' => [
                'e41fec7c-6183-48b3-8113-afc14feafa24',
                'e41fec7c-6183-48b3-8113-afc14feafa25',
            ],
        ];
        $companyIds = [1, 5];

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyIdsByCustomerReferenceAndUuids')
            ->with($customerReference, $groupedIdentifiers['uuid'])
            ->willReturn($companyIds);

        static::assertEquals(
            $companyIds,
            $this->companyReader->getIdsByCustomerReferenceAndGroupedIdentifier($customerReference, $groupedIdentifiers),
        );
    }

    /**
     * @return void
     */
    public function testGetIdsByCustomerReferenceAndGroupedIdentifierWithoutUuids(): void
    {
        $customerReference = 'FOO--1';
        $groupedIdentifiers = [
            'uuid' => [],
        ];
        $companyIds = [];

        $this->repositoryMock->expects(static::never())
            ->method('getCompanyIdsByCustomerReferenceAndUuids');

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
        $uuids = [
            'e41fec7c-6183-48b3-8113-afc14feafa24',
            'e41fec7c-6183-48b3-8113-afc14feafa25',
        ];
        $companyIds = [1, 5];

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyIdsByCustomerReferenceAndUuids')
            ->with($customerReference, $uuids)
            ->willReturn($companyIds);

        static::assertEquals(
            $companyIds,
            $this->companyReader->getIdsByCustomerReferenceAndUuids($customerReference, $uuids),
        );
    }
}
