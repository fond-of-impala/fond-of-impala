<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Communication;

use FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader\ErpOrderCancellationReader;
use FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader\ReaderInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationRepositoryInterface getRepository()
 */
class ErpOrderCancellationCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader\ReaderInterface
     */
    public function createErpOrderCancellationReader(): ReaderInterface
    {
        return new ErpOrderCancellationReader($this->getRepository());
    }
}
