<?php

namespace FondOfImpala\Zed\CompanyTypeRole;

use Codeception\Test\Unit;
use FondOfImpala\Shared\CompanyTypeRole\CompanyTypeRoleConstants;

class CompanyTypeRoleConfigTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyTypeRoleConfig;

    /**
     * @var array
     */
    protected $validCompanyTypeNames = ['retailer', 'manufacturer', 'x'];

    /**
     * @var array
     */
    protected $predefinedPermissionKeys = [
        'x' => [
            'super_administration' => ['APermissionPlugin', 'BPermissionPlugin'],
            'customer_service' => ['APermissionPlugin', 'BPermissionPlugin'],
            'order_management' => ['APermissionPlugin', 'BPermissionPlugin'],
            'distribution_management' => ['APermissionPlugin', 'BPermissionPlugin', 'CPermissionPlugin'],
            'sales_coordination' => ['APermissionPlugin', 'BPermissionPlugin'],
            'distribution' => ['APermissionPlugin', 'BPermissionPlugin'],
            'administration' => ['APermissionPlugin', 'BPermissionPlugin'],
            'marketing' => ['APermissionPlugin'],
        ],
        'retailer' => [
            'super_administration' => ['APermissionPlugin', 'BPermissionPlugin', 'CPermissionPlugin'],
            'customer_service' => ['APermissionPlugin', 'BPermissionPlugin', 'CPermissionPlugin'],
            'order_management' => ['APermissionPlugin', 'BPermissionPlugin', 'CPermissionPlugin'],
            'distribution_management' => ['APermissionPlugin', 'BPermissionPlugin', 'CPermissionPlugin'],
            'sales_coordination' => ['APermissionPlugin', 'BPermissionPlugin', 'CPermissionPlugin'],
            'distribution' => ['APermissionPlugin', 'BPermissionPlugin', 'CPermissionPlugin'],
            'administration' => ['APermissionPlugin', 'BPermissionPlugin', 'CPermissionPlugin'],
            'marketing' => ['APermissionPlugin'],
            'purchase' => ['APermissionPlugin', 'BPermissionPlugin'],
        ], 'manufacturer' => [
            'administration' => ['APermissionPlugin', 'BPermissionPlugin', 'CPermissionPlugin'],
            'distribution' => ['APermissionPlugin', 'BPermissionPlugin', 'CPermissionPlugin'],
            'super_distribution' => ['APermissionPlugin', 'BPermissionPlugin', 'CPermissionPlugin'],
            'distribution_management' => ['APermissionPlugin', 'BPermissionPlugin', 'CPermissionPlugin'],
            'customer_service' => ['APermissionPlugin', 'BPermissionPlugin', 'CPermissionPlugin'],
            'order_management' => ['APermissionPlugin', 'BPermissionPlugin', 'CPermissionPlugin'],
            'sales_coordination' => ['APermissionPlugin', 'BPermissionPlugin', 'CPermissionPlugin'],
        ],
    ];

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyTypeRoleConfig = new class ($this->validCompanyTypeNames, $this->predefinedPermissionKeys) extends CompanyTypeRoleConfig {
            protected array $validCompanyTypeNames;

            protected array $predefinedPermissionKeys;

            /**
             * @param array $validCompanyTypeNames
             * @param array $predefinedPermissionKeys
             */
            public function __construct(array $validCompanyTypeNames, array $predefinedPermissionKeys)
            {
                $this->validCompanyTypeNames = $validCompanyTypeNames;
                $this->predefinedPermissionKeys = $predefinedPermissionKeys;
            }

            /**
             * @param string $key
             * @param mixed|null $default
             *
             * @return mixed
             */
            protected function get($key, $default = null)
            {
                if ($key === CompanyTypeRoleConstants::VALID_COMPANY_TYPE_NAMES) {
                    return $this->validCompanyTypeNames;
                }

                if ($key === CompanyTypeRoleConstants::PERMISSION_KEYS) {
                    return $this->predefinedPermissionKeys;
                }

                return parent::get($key, $default);
            }
        };
    }

    /**
     * @return void
     */
    public function testGetPredefinedCompanyRolesWithInvalidCompanyTypeName(): void
    {
        $companyTypeName = 'y';

        $predefinedCompanyRoles = $this->companyTypeRoleConfig->getPredefinedCompanyRolesByCompanyTypeName(
            $companyTypeName,
        );

        $this->assertEmpty($predefinedCompanyRoles);
    }

    /**
     * @return void
     */
    public function testGetPredefinedCompanyRolesForManufacturer(): void
    {
        $companyTypeName = 'manufacturer';

        $predefinedCompanyRoles = $this->companyTypeRoleConfig->getPredefinedCompanyRolesByCompanyTypeName(
            $companyTypeName,
        );

        $this->assertCount(count($this->predefinedPermissionKeys[$companyTypeName]), $predefinedCompanyRoles);
    }

    /**
     * @return void
     */
    public function testGetPredefinedCompanyRolesForRetailer(): void
    {
        $companyTypeName = 'retailer';

        $predefinedCompanyRoles = $this->companyTypeRoleConfig->getPredefinedCompanyRolesByCompanyTypeName(
            $companyTypeName,
        );

        $this->assertCount(count($this->predefinedPermissionKeys[$companyTypeName]), $predefinedCompanyRoles);
    }

    /**
     * @return void
     */
    public function testGetPredefinedCompanyRolesForX(): void
    {
        $companyTypeName = 'x';

        $predefinedCompanyRoles = $this->companyTypeRoleConfig->getPredefinedCompanyRolesByCompanyTypeName(
            $companyTypeName,
        );

        $this->assertCount(count($this->predefinedPermissionKeys[$companyTypeName]), $predefinedCompanyRoles);
    }
}
