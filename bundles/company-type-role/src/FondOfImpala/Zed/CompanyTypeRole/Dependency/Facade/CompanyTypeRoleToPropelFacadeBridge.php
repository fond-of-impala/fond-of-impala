<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade;

use Spryker\Zed\Propel\Business\PropelFacadeInterface;

class CompanyTypeRoleToPropelFacadeBridge implements CompanyTypeRoleToPropelFacadeInterface
{
    protected PropelFacadeInterface $propelFacade;

    /**
     * @param \Spryker\Zed\Propel\Business\PropelFacadeInterface $propelFacade
     */
    public function __construct(PropelFacadeInterface $propelFacade)
    {
        $this->propelFacade = $propelFacade;
    }

    /**
     * @return string
     */
    public function getCurrentDatabaseEngine(): string
    {
        return $this->propelFacade->getCurrentDatabaseEngine();
    }
}
