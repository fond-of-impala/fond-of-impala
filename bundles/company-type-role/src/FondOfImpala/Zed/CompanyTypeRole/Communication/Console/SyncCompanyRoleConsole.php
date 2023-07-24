<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Communication\Console;

use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \FondOfImpala\Zed\CompanyTypeRole\Business\CompanyTypeRoleFacadeInterface getFacade()
 */
class SyncCompanyRoleConsole extends Console
{
    /**
     * @var string
     */
    protected const COMMAND_NAME = 'company-type-role:company-role:sync';

    /**
     * @var string
     */
    protected const DESCRIPTION = 'Sync role for companies.';

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
        $this->getFacade()->syncCompanyRoles();

        return 0;
    }
}
