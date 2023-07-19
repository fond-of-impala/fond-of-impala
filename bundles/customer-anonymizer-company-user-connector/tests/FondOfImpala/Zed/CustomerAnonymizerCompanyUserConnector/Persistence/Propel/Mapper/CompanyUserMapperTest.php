<?php

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Persistence\Propel\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\SpyCompanyEntityTransfer;
use Generated\Shared\Transfer\SpyCompanyUserEntityTransfer;
use Generated\Shared\Transfer\SpyCustomerEntityTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyUserMapperTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\SpyCompanyUserEntityTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected SpyCompanyUserEntityTransfer|MockObject $spyCompanyUserEntityTransfer;

    /**
     * @var \Generated\Shared\Transfer\SpyCustomerEntityTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected SpyCustomerEntityTransfer|MockObject $spyCustomerEntityTransfer;

    /**
     * @var \Generated\Shared\Transfer\SpyCompanyEntityTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected SpyCompanyEntityTransfer|MockObject $spyCompanyEntityTransfer;

    /**
     * @var \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Persistence\Propel\Mapper\CompanyUserMapper
     */
    protected CompanyUserMapper $mapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->spyCompanyUserEntityTransfer = $this->getMockBuilder(SpyCompanyUserEntityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->spyCustomerEntityTransfer = $this->getMockBuilder(SpyCustomerEntityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->spyCompanyEntityTransfer = $this->getMockBuilder(SpyCompanyEntityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mapper = new CompanyUserMapper();
    }

    /**
     * @return void
     */
    public function testMapCompanyUserCollection(): void
    {
        $this->spyCompanyUserEntityTransfer->expects(static::atLeastOnce())
            ->method('modifiedToArray')
            ->willReturn([]);

        $this->spyCompanyUserEntityTransfer->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->spyCustomerEntityTransfer);

        $this->spyCompanyUserEntityTransfer->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->spyCompanyEntityTransfer);

        $this->spyCustomerEntityTransfer->expects(static::atLeastOnce())
            ->method('modifiedToArray')
            ->willReturn([]);

        $this->spyCompanyEntityTransfer->expects(static::atLeastOnce())
            ->method('modifiedToArray')
            ->willReturn([]);

        $this->mapper->mapCompanyUserCollection([$this->spyCompanyUserEntityTransfer]);
    }

    /**
     * @return void
     */
    public function testMapEntityTransferToCompanyUserTransfer(): void
    {
        $this->spyCompanyUserEntityTransfer->expects(static::atLeastOnce())
            ->method('modifiedToArray')
            ->willReturn([]);

        $this->spyCompanyUserEntityTransfer->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->spyCustomerEntityTransfer);

        $this->spyCompanyUserEntityTransfer->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->spyCompanyEntityTransfer);

        $this->spyCustomerEntityTransfer->expects(static::atLeastOnce())
            ->method('modifiedToArray')
            ->willReturn([]);

        $this->spyCompanyEntityTransfer->expects(static::atLeastOnce())
            ->method('modifiedToArray')
            ->willReturn([]);

        $this->mapper->mapEntityTransferToCompanyUserTransfer($this->spyCompanyUserEntityTransfer);
    }
}
