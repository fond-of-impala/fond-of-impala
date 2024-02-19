<?php

namespace FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Communication\Plugin\PermissionExtension;

use Codeception\Test\Unit;

class CanBulkPersistOrderBudgetsPermissionPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Communication\Plugin\PermissionExtension\CanBulkPersistOrderBudgetsPermissionPlugin
     */
    protected CanBulkPersistOrderBudgetsPermissionPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->plugin = new CanBulkPersistOrderBudgetsPermissionPlugin();
    }

    /**
     * @return void
     */
    public function testGetKey(): void
    {
        static::assertEquals(
            CanBulkPersistOrderBudgetsPermissionPlugin::KEY,
            $this->plugin->getKey(),
        );
    }
}
