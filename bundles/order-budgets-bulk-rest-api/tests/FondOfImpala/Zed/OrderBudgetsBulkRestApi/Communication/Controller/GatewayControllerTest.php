<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Communication\Controller;

use Codeception\Test\Unit;

class GatewayControllerTest extends Unit
{
    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->gatewayController = new GatewayController();
    }
}
