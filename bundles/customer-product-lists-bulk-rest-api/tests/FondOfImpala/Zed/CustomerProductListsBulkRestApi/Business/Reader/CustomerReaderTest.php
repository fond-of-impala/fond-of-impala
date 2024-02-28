<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Persistence\CustomerProductListsBulkRestApiRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerReaderTest extends Unit
{
    protected MockObject|CustomerProductListsBulkRestApiRepositoryInterface $repositoryMock;

    protected CustomerReader $customerReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this->getMockBuilder(CustomerProductListsBulkRestApiRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerReader = new CustomerReader(
            $this->repositoryMock,
        );
    }

    /**
     * @return void
     */
    public function testGetIdsByGroupedIdentifier(): void
    {
        $groupedIdentifiers = [
            'email' => [
                'foo@bar.com',
            ],
            'customerReference' => ['FOO--1'],
        ];
        $customerIds = ['foo@bar.com' => 1, 'FOO--1' => 5];

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCustomerIdsByCustomerReferences')
            ->with($groupedIdentifiers['customerReference'])
            ->willReturn(['FOO--1' => 5]);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCustomerIdsByEmails')
            ->with($groupedIdentifiers['email'])
            ->willReturn(['foo@bar.com' => 1]);

        static::assertEquals(
            $customerIds,
            $this->customerReader->getIdsByGroupedIdentifier($groupedIdentifiers),
        );
    }

    /**
     * @return void
     */
    public function testGetIdsByGroupedIdentifierWithoutEmails(): void
    {
        $groupedIdentifiers = [
            'email' => [],
            'customerReference' => ['FOO--1'],
        ];
        $customerIds = ['FOO--1' => 5];

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCustomerIdsByCustomerReferences')
            ->with($groupedIdentifiers['customerReference'])
            ->willReturn(['FOO--1' => 5]);

        $this->repositoryMock->expects(static::never())
            ->method('getCustomerIdsByEmails');

        static::assertEquals(
            $customerIds,
            $this->customerReader->getIdsByGroupedIdentifier($groupedIdentifiers),
        );
    }

    /**
     * @return void
     */
    public function testGetIdsByCustomerReferences(): void
    {
        $customerReferences = ['FOO--1'];
        $customerIds = ['FOO--1' => 5];

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCustomerIdsByCustomerReferences')
            ->with($customerReferences)
            ->willReturn($customerIds);

        static::assertEquals(
            $customerIds,
            $this->customerReader->getIdsByCustomerReferences($customerReferences),
        );
    }

    /**
     * @return void
     */
    public function testGetIdsByEmails(): void
    {
        $emails = ['foo@bar.com'];
        $customerIds = ['foo@bar.com' => 5];

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCustomerIdsByEmails')
            ->with($emails)
            ->willReturn($customerIds);

        static::assertEquals(
            $customerIds,
            $this->customerReader->getIdsByEmails($emails),
        );
    }
}
