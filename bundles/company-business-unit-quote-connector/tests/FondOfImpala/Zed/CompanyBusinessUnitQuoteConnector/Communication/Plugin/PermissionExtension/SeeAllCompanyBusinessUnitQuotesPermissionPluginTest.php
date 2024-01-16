<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Communication\Plugin\PermissionExtension;

use Codeception\Test\Unit;

class SeeAllCompanyBusinessUnitQuotesPermissionPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Communication\Plugin\PermissionExtension\SeeAllCompanyBusinessUnitQuotesPermissionPlugin
     */
    protected $seeAllCompanyBusinessUnitQuotesPermissionPlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->seeAllCompanyBusinessUnitQuotesPermissionPlugin = new SeeAllCompanyBusinessUnitQuotesPermissionPlugin();
    }

    /**
     * @return void
     */
    public function testGetKey(): void
    {
        self::assertEquals(
            SeeAllCompanyBusinessUnitQuotesPermissionPlugin::KEY,
            $this->seeAllCompanyBusinessUnitQuotesPermissionPlugin->getKey(),
        );
    }
}
