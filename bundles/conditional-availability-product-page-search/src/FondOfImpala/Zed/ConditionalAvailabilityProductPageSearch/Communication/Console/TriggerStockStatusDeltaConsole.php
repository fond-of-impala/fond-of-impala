<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication\Console;

use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\ConditionalAvailabilityProductPageSearchFacadeInterface getFacade()
 */
class TriggerStockStatusDeltaConsole extends Console
{
    /**
     * @var string
     */
    public const COMMAND_NAME = 'conditional-availability-product-page-search:stock-status-delta:trigger';

    /**
     * @var string
     */
    public const DESCRIPTION = 'This command will trigger products with stock status delta.';

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
        $this->info('Trigger stock status delta');
        $this->getFacade()->triggerStockStatusDelta();

        return static::CODE_SUCCESS;
    }
}
