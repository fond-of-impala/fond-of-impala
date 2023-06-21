<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication\Console;

use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchQueryContainerInterface getQueryContainer()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\ConditionalAvailabilityPageSearchFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchRepositoryInterface getRepository()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication\ConditionalAvailabilityPageSearchCommunicationFactory getFactory()
 */
class ConditionalAvailabilityPageSearchPublishConsole extends Console
{
    /**
     * @var string
     */
    public const COMMAND_NAME = 'conditional-availability-page-search:publish';

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription('Publish ...');

        parent::configure();
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->info('Publish');
        $this->getFacade()->publish([16, 17]);

        return null;
    }
}
