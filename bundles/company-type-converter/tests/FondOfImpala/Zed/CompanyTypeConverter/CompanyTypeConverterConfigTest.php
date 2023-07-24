<?php

namespace FondOfImpala\Zed\CompanyTypeConverter;

use Codeception\Test\Unit;
use FondOfImpala\Shared\CompanyTypeConverter\CompanyTypeConverterConstants;

class CompanyTypeConverterConfigTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyTypeConverter\CompanyTypeConverterConfig|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyTypeConverterConfig;

    /**
     * @var array
     */
    protected $companyTypeDefaultRolesMapping = [
        'retailer' => [
            'super_administration' => 'super_administration',
            'customer_service' => 'customer_service',
            'distribution' => 'distribution',
            'administration' => 'administration',
            'purchase' => 'administration',
            'marketing' => 'administration',
        ],
        'distributor' => [
            'super_administration' => 'super_administration',
            'customer_service' => 'customer_service',
            'distribution' => 'distribution',
            'administration' => 'administration',
            'purchase' => 'administration',
            'marketing' => 'administration',
        ],
        'manufacturer' => [
            'super_administration' => 'administration',
            'customer_service' => 'customer_service',
            'distribution' => 'distribution',
            'administration' => 'administration',
            'purchase' => 'administration',
            'marketing' => 'administration',
        ],
    ];

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyTypeConverterConfig = new class ($this->companyTypeDefaultRolesMapping) extends CompanyTypeConverterConfig {
            /**
             * @var string[]
             */
            protected $companyTypeConverterConfig;

            /**
             *  constructor.
             *
             * @param array $companyTypeDefaultRolesMapping
             */
            public function __construct(array $companyTypeDefaultRolesMapping)
            {
                $this->companyTypeDefaultRolesMapping = $companyTypeDefaultRolesMapping;
            }

            /**
             * @param string $key
             * @param mixed|null $default
             *
             * @return mixed
             */
            protected function get($key, $default = null)
            {
                if ($key === CompanyTypeConverterConstants::COMPANY_TYPE_DEFAULT_ROLES_MAPPING) {
                    return $this->companyTypeDefaultRolesMapping;
                }

                return parent::get($key, $default);
            }
        };
    }

    /**
     * @return void
     */
    public function testGetCompanyTypeDefaultRoleMapping(): void
    {
        $companyTypeDefaultCompanyRoles = $this->companyTypeConverterConfig->getCompanyTypeDefaultRoleMapping('retailer');

        $this->assertNotEmpty($companyTypeDefaultCompanyRoles);
        $this->assertEquals($companyTypeDefaultCompanyRoles['super_administration'], 'super_administration');
    }
}
