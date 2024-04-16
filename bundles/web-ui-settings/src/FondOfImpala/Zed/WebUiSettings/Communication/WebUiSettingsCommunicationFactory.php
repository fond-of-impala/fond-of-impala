<?php

namespace FondOfImpala\Zed\WebUiSettings\Communication;

use Psr\Log\LoggerInterface;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class WebUiSettingsCommunicationFactory extends AbstractCommunicationFactory
{
    use LoggerTrait;

    /**
     * @return \Psr\Log\LoggerInterface
     */
    public function getProvidedLogger(): LoggerInterface
    {
        return $this->getLogger();
    }
}
