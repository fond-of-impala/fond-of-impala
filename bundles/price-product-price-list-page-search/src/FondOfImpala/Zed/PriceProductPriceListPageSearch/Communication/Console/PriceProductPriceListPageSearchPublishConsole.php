<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\Console;

use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\PriceProductPriceListPageSearchFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchQueryContainerInterface getQueryContainer()
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchRepositoryInterface getRepository()
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\PriceProductPriceListPageSearchCommunicationFactory getFactory()
 */
class PriceProductPriceListPageSearchPublishConsole extends Console
{
    /**
     * @var string
     */
    public const COMMAND_NAME = 'price-product-price-list:publish';

    /**
     * @var string
     */
    public const DESCRIPTION = 'Publish resource price_product_[abstract|concrete]_price_list by idPriceList.';

    /**
     * @var string
     */
    public const TYPE_OPTION = 'type';

    /**
     * @var string
     */
    public const TYPE_OPTION_SHORTCUT = 't';

    /**
     * @var string
     */
    public const ID_PRICE_LIST_OPTION = 'id-price-list';

    /**
     * @var string
     */
    public const ID_PRICE_LIST_OPTION_SHORTCUT = 'i';

    /**
     * @var string
     */
    protected const TYPE_ABSTRACT = 'abstract';

    /**
     * @var string
     */
    protected const TYPE_CONCRETE = 'concrete';

    /**
     * @var string
     */
    protected const ERROR_MESSAGE = '<error>The option "type" can only be "abstract" or "concrete".</error>';

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->addOption(static::TYPE_OPTION, static::TYPE_OPTION_SHORTCUT, InputArgument::OPTIONAL);
        $this->addOption(static::ID_PRICE_LIST_OPTION, static::ID_PRICE_LIST_OPTION_SHORTCUT, InputArgument::OPTIONAL);

        $this->setName(static::COMMAND_NAME)
            ->setDescription(static::DESCRIPTION)
            ->addUsage(sprintf('-%s type -%s 1', static::TYPE_OPTION_SHORTCUT, static::ID_PRICE_LIST_OPTION_SHORTCUT));
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $type = $input->getOption(static::TYPE_OPTION);
        $idPriceList = $input->getOption(static::ID_PRICE_LIST_OPTION);

        switch ($type) {
            case static::TYPE_ABSTRACT:
                $this->getFacade()->publishAbstractPriceProductPriceListByIdPriceList($idPriceList);

                break;
            case static::TYPE_CONCRETE:
                $this->getFacade()->publishConcretePriceProductPriceListByIdPriceList($idPriceList);

                break;
            default:
                $output->writeln(static::ERROR_MESSAGE);
        }

        return 0;
    }
}
