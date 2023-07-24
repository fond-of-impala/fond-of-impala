<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Communication\Console;

use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \FondOfImpala\Zed\CompanyTypeRole\Business\CompanyTypeRoleFacadeInterface getFacade()
 */
class SyncPermissionConsole extends Console
{
    /**
     * @var string
     */
    protected const COMMAND_NAME = 'company-type-role:permission:sync';

    /**
     * @var string
     */
    protected const DESCRIPTION = 'Sync permission for company type roles.';

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName(static::COMMAND_NAME);
        $this->setDescription(static::DESCRIPTION);

        parent::configure();
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->getFacade()->syncPermissions();

        return 0;
    }
}
