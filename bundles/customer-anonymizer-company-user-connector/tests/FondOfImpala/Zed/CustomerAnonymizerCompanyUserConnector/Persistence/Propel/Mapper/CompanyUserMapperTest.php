<?php

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Persistence\Propel\Mapper;

use Codeception\Test\Unit;
use Orm\Zed\Company\Persistence\SpyCompany;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUser;
use Orm\Zed\Customer\Persistence\SpyCustomer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyUserMapperTest extends Unit
{
    /**
     * @var \Orm\Zed\CompanyUser\Persistence\SpyCompanyUser|\PHPUnit\Framework\MockObject\MockObject
     */
    protected SpyCompanyUser|MockObject $spyCompanyUserEntityMock;

    /**
     * @var \Orm\Zed\Customer\Persistence\SpyCustomer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected SpyCustomer|MockObject $spyCustomerMock;

    /**
     * @var \Orm\Zed\Company\Persistence\SpyCompany|\PHPUnit\Framework\MockObject\MockObject
     */
    protected SpyCompany|MockObject $spyCompanyMock;

    /**
     * @var \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Persistence\Propel\Mapper\CompanyUserMapper
     */
    protected CompanyUserMapper $mapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->spyCompanyUserEntityMock = $this->getMockBuilder(SpyCompanyUser::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->spyCustomerMock = $this->getMockBuilder(SpyCustomer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->spyCompanyMock = $this->getMockBuilder(SpyCompanyUser::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mapper = new CompanyUserMapper();
    }

    /**
     * @return void
     */
    public function testMapCompanyUserCollection(): void
    {
        $this->spyCompanyUserEntityMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->spyCompanyUserEntityMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->spyCustomerMock);

        $this->spyCompanyUserEntityMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->spyCompanyMock);

        $this->spyCustomerMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->spyCompanyMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->mapper->mapCompanyUserCollection([$this->spyCompanyUserEntityMock]);
    }

    /**
     * @return void
     */
    public function testMapEntityToCompanyUserTransfer(): void
    {
        $this->spyCompanyUserEntityMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->spyCompanyUserEntityMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->spyCustomerMock);

        $this->spyCompanyUserEntityMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->spyCompanyMock);

        $this->spyCustomerMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->spyCompanyMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->mapper->mapEntityToCompanyUserTransfer($this->spyCompanyUserEntityMock);
    }
}
