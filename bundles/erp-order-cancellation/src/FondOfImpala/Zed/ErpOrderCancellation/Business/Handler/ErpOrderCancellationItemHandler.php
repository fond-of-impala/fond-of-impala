<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Business\Handler;

use ArrayObject;
use FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader\ErpOrderCancellationItemReaderInterface;
use FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Writer\ErpOrderCancellationItemWriterInterface;
use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;

class ErpOrderCancellationItemHandler implements ErpOrderCancellationItemHandlerInterface
{
    /**
     * @var string
     */
    protected const NEW = 'new';

    /**
     * @var string
     */
    protected const UPDATE = 'update';

    /**
     * @var string
     */
    protected const DELETE = 'delete';

    /**
     * @var string
     */
    protected const UNTOUCHED = 'untouched';

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Writer\ErpOrderCancellationItemWriterInterface
     */
    protected $erpOrderCancellationItemWriter;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader\ErpOrderCancellationItemReaderInterface
     */
    protected $erpOrderCancellationItemReader;

    /**
     * @param \FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Writer\ErpOrderCancellationItemWriterInterface $erpOrderCancellationItemWriter
     * @param \FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader\ErpOrderCancellationItemReaderInterface $erpOrderCancellationItemReader
     */
    public function __construct(
        ErpOrderCancellationItemWriterInterface $erpOrderCancellationItemWriter,
        ErpOrderCancellationItemReaderInterface $erpOrderCancellationItemReader
    ) {
        $this->erpOrderCancellationItemWriter = $erpOrderCancellationItemWriter;
        $this->erpOrderCancellationItemReader = $erpOrderCancellationItemReader;
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function handle(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationTransfer
    {
        $preparedItems = $this->prepareItems($erpOrderCancellationTransfer);
        $collection = new ArrayObject();
        $orderId = $erpOrderCancellationTransfer->getIdErpOrderCancellation();

        foreach ($preparedItems[static::DELETE] as $erpOrderCancellationItemTransfer) {
            $this->delete($erpOrderCancellationItemTransfer->getFkErpOrderCancellationOrFail(), $erpOrderCancellationItemTransfer->getSku());
        }

        foreach ($preparedItems[static::UPDATE] as $erpOrderCancellationItemTransfer) {
            $erpOrderCancellationItemTransfer->setFkErpOrderCancellation($orderId);
            $erpOrderCancellationItemTransfer = $this->update($erpOrderCancellationItemTransfer);
            $collection->append($erpOrderCancellationItemTransfer);
        }

        foreach ($preparedItems[static::NEW] as $erpOrderCancellationItemTransfer) {
            $erpOrderCancellationItemTransfer->setFkErpOrderCancellation($orderId);
            $erpOrderCancellationItemTransfer = $this->create($erpOrderCancellationItemTransfer);
            $collection->append($erpOrderCancellationItemTransfer);
        }

        foreach ($preparedItems[static::UNTOUCHED] as $data) {
            /** @phpstan-ignore-next-line */
            if (is_array($data)) {
                foreach ($data as $item) {
                    $collection->append($item);
                }

                continue;
            }
            $collection->append($data);
        }

        return $erpOrderCancellationTransfer->setCancellationItems($collection);
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    protected function create(ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransfer): ErpOrderCancellationItemTransfer
    {
        return $this->erpOrderCancellationItemWriter->create($erpOrderCancellationItemTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    protected function update(ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransfer): ErpOrderCancellationItemTransfer
    {
        $erpOrderCancellationItemTransfer->requireFkErpOrderCancellation()->requireSku();

        $item = $this->erpOrderCancellationItemReader->findErpOrderCancellationItemByIdErpOrderCancellationAndSku($erpOrderCancellationItemTransfer->getFkErpOrderCancellation(), $erpOrderCancellationItemTransfer->getSku());
        $createdAt = $item->getCreatedAt();
        $item->fromArray($erpOrderCancellationItemTransfer->toArray(), true)
            ->setCreatedAt($createdAt)
            ->setUpdatedAt(time());

        return $this->erpOrderCancellationItemWriter->update($item);
    }

    /**
     * @param int $fkErpOrderCancellation
     * @param string $sku
     *
     * @return void
     */
    protected function delete(int $fkErpOrderCancellation, string $sku): void
    {
        $this->erpOrderCancellationItemWriter->delete($fkErpOrderCancellation, $sku);
    }

    /**
     * @param int $idErpOrderCancellation
     *
     * @return array<array<\Generated\Shared\Transfer\ErpOrderCancellationItemTransfer>>
     */
    protected function getExistingErpOrderCancellationItems(int $idErpOrderCancellation): array
    {
        $itemsCollection = $this->erpOrderCancellationItemReader->findErpOrderCancellationItemsByIdErpOrderCancellation($idErpOrderCancellation);
        $existingItems = [];
        foreach ($itemsCollection as $itemTransfer) {
            $existingItems[$this->getItemIndex($itemTransfer)][] = $itemTransfer;
        }

        return $existingItems;
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer $itemTransfer
     *
     * @return string
     */
    protected function getItemIndex(ErpOrderCancellationItemTransfer $itemTransfer): string
    {
        return sprintf('%s|%s', $itemTransfer->getSku(), $itemTransfer->getLineId());
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return array<array<\Generated\Shared\Transfer\ErpOrderCancellationItemTransfer>>
     */
    protected function prepareItems(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): array
    {
        $erpOrderCancellationTransfer->requireIdErpOrderCancellation();

        $existingItems = $this->getExistingErpOrderCancellationItems($erpOrderCancellationTransfer->getIdErpOrderCancellation());
        $new = [];
        $update = [];
        $delete = [];

        foreach ($erpOrderCancellationTransfer->getCancellationItems() as $erpOrderCancellationItemTransfer) {
            $itemIndex = $this->getItemIndex($erpOrderCancellationItemTransfer);
            if (array_key_exists($itemIndex, $existingItems)) {
                $item = $this->updateItemData(array_pop($existingItems[$itemIndex]), $erpOrderCancellationItemTransfer);
                if ($item->getCancellationQuantity() > 0) {
                    $update[] = $item;
                }
                if ($item->getCancellationQuantity() === 0) {
                    $delete[] = $item;
                }
                if (count($existingItems[$itemIndex]) === 0) {
                    unset($existingItems[$itemIndex]);
                }

                continue;
            }

            if ($erpOrderCancellationItemTransfer->getCancellationQuantity() > 0) {
                $new[] = $erpOrderCancellationItemTransfer;
            }
        }

        return [
            static::NEW => $new,
            static::UPDATE => $update,
            static::DELETE => $delete,
            static::UNTOUCHED => $existingItems,
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer $updateItem
     * @param \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    protected function updateItemData(
        ErpOrderCancellationItemTransfer $updateItem,
        ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransfer
    ): ErpOrderCancellationItemTransfer {
        $fkErpOrderCancellation = $updateItem->getFkErpOrderCancellation();
        $updateItem->fromArray($erpOrderCancellationItemTransfer->modifiedToArray(), true);
        $updateItem->setFkErpOrderCancellation($fkErpOrderCancellation);

        return $updateItem;
    }
}
