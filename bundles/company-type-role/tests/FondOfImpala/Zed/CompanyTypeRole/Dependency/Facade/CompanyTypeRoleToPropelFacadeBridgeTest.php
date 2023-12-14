<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade;

use Codeception\Test\Unit;
use Spryker\Zed\Propel\Business\PropelFacadeInterface;

class CompanyTypeRoleToPropelFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Spryker\Zed\Propel\Business\PropelFacadeInterface&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected $facadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPropelFacadeBridge
     */
    protected $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(PropelFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new CompanyTypeRoleToPropelFacadeBridge($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testGetCurrentDatabaseEngine(): void
    {
        $currentDatabaseEngine = 'psql';

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('getCurrentDatabaseEngine')
            ->willReturn($currentDatabaseEngine);

        static::assertEquals(
            $currentDatabaseEngine,
            $this->bridge->getCurrentDatabaseEngine(),
        );
    }
}
