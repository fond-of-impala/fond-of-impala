<?php

namespace FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Business\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Persistence\CompanyTypeProductListsBulkRestApiRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerReaderTest extends Unit
{
    protected MockObject|CompanyTypeProductListsBulkRestApiRepositoryInterface $repositoryMock;

    protected CustomerReader $customerReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this->getMockBuilder(CompanyTypeProductListsBulkRestApiRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerReader = new CustomerReader($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testGetIdsByCustomerReferenceAndGroupedIdentifier(): void
    {
        $customerReference = 'FOO--1';
        $customerReferenceMap = ['FOO--3' => 3, 'FOO--4' => 4];
        $emailMap = ['foo@bar.com' => 6, 'bar@foo.com' => 9];
        $groupedIdentifiers = [
            'customerReference' => [
                'FOO--3',
                'FOO--4',
            ], 'email' => [
                'foo@bar.com',
                'bar@foo.com',
            ],
        ];

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getColleagueIdsByCustomerReferenceAndColleagueReferences')
            ->with($customerReference, $groupedIdentifiers['customerReference'])
            ->willReturn($customerReferenceMap);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getColleagueIdsByCustomerReferenceAndColleagueEmails')
            ->with($customerReference, $groupedIdentifiers['email'])
            ->willReturn($emailMap);

        static::assertEquals(
            $customerReferenceMap + $emailMap,
            $this->customerReader->getIdsByCustomerReferenceAndGroupedIdentifier(
                $customerReference,
                $groupedIdentifiers,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetIdsByCustomerReferenceAndGroupedIdentifierWithoutEmails(): void
    {
        $customerReference = 'FOO--1';
        $customerReferenceMap = ['FOO--3' => 3, 'FOO--4' => 4];
        $groupedIdentifiers = [
            'customerReference' => [
                'FOO--3',
                'FOO--4',
            ], 'email' => [],
        ];

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getColleagueIdsByCustomerReferenceAndColleagueReferences')
            ->with($customerReference, $groupedIdentifiers['customerReference'])
            ->willReturn($customerReferenceMap);

        $this->repositoryMock->expects(static::never())
            ->method('getColleagueIdsByCustomerReferenceAndColleagueEmails');

        static::assertEquals(
            $customerReferenceMap,
            $this->customerReader->getIdsByCustomerReferenceAndGroupedIdentifier(
                $customerReference,
                $groupedIdentifiers,
            ),
        );
    }
}
