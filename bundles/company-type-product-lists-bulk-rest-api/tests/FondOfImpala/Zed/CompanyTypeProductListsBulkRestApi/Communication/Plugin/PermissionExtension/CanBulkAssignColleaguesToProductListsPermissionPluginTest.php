<?php

namespace FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Communication\Plugin\PermissionExtension;

use Codeception\Test\Unit;

class CanBulkAssignColleaguesToProductListsPermissionPluginTest extends Unit
{
    protected CanBulkAssignColleaguesToProductListsPermissionPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->plugin = new CanBulkAssignColleaguesToProductListsPermissionPlugin();
    }

    /**
     * @return void
     */
    public function testGetKey(): void
    {
        static::assertEquals(
            CanBulkAssignColleaguesToProductListsPermissionPlugin::KEY,
            $this->plugin->getKey(),
        );
    }
}
