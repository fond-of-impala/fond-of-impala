<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Mapper;

use Codeception\Test\Unit;

class CompanyUserMapperTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyUserMapper
     */
    protected $companyUserMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyUserMapper = new CompanyUserMapper();
    }

    /**
     * @return void
     */
    public function testFromNonManufacturerData(): void
    {
        $nonManufacturerData = [
            [
                'id_company' => 1,
                'id_company_business_unit' => 1,
                'id_company_role' => 1,
            ],
        ];

        $companyUserTransfers = $this->companyUserMapper->fromNonManufacturerData($nonManufacturerData);

        static::assertCount(1, $companyUserTransfers);

        static::assertEquals($nonManufacturerData[0]['id_company'], $companyUserTransfers[0]->getFkCompany());

        static::assertEquals(
            $nonManufacturerData[0]['id_company_business_unit'],
            $companyUserTransfers[0]->getFkCompanyBusinessUnit(),
        );

        static::assertEquals(
            $nonManufacturerData[0]['id_company_role'],
            $companyUserTransfers[0]->getCompanyRoleCollection()->getRoles()->offsetGet(0)->getIdCompanyRole(),
        );
    }

    /**
     * @return void
     */
    public function testFromNonManufacturerDataItem(): void
    {
        $nonManufacturerDataItem = [
            'id_company' => 1,
            'id_company_business_unit' => 1,
            'id_company_role' => 1,
        ];

        $companyUserTransfer = $this->companyUserMapper->fromNonManufacturerDataItem($nonManufacturerDataItem);

        static::assertEquals($nonManufacturerDataItem['id_company'], $companyUserTransfer->getFkCompany());

        static::assertEquals(
            $nonManufacturerDataItem['id_company_business_unit'],
            $companyUserTransfer->getFkCompanyBusinessUnit(),
        );

        static::assertEquals(
            $nonManufacturerDataItem['id_company_role'],
            $companyUserTransfer->getCompanyRoleCollection()->getRoles()->offsetGet(0)->getIdCompanyRole(),
        );
    }
}
