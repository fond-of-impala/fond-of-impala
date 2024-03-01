<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Business\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListsBulkRestApi\Persistence\ProductListsBulkRestApiRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;

class ProductListReaderTest extends Unit
{
    protected ProductListReaderInterface $reader;

    protected MockObject|ProductListsBulkRestApiRepositoryInterface $repositoryMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this->getMockBuilder(ProductListsBulkRestApiRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->reader = new ProductListReader($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testGetIdsByUuids(): void
    {
        $uuids = ['xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'];
        $productListIds = [
            0 => [
                'spy_product_list.uuid' => 1,
            ],
        ];

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getProductListIdsByUuids')
            ->with($uuids)
            ->willReturn($productListIds);

        $response = $this->reader->getIdsByUuids($uuids);

        static::assertIsArray($response);
        static::assertEquals($productListIds, $response);
    }

    /**
     * @return void
     */
    public function testGetIdsByKeys(): void
    {
        $keys = ['key'];
        $productListIds = [
            0 => [
                'spy_product_list.key' => 1,
            ],
        ];

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getProductListIdsByKeys')
            ->with($keys)
            ->willReturn($productListIds);

        $response = $this->reader->getIdsByKeys($keys);

        static::assertIsArray($response);
        static::assertEquals($productListIds, $response);
    }

    /**
     * @return void
     */
    public function testGetIdsByGroupedIdentifier(): void
    {
        $groupedIdentifiers = [
            'uuid' => ['xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'],
            'key' => ['key'],
        ];

        $uuidProductListIds = [
            0 => [
                'spy_product_list.uuid' => 1,
            ],
        ];

        $keyProductListIds = [
            0 => [
                'spy_product_list.key' => 1,
            ],
        ];

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getProductListIdsByUuids')
            ->with($groupedIdentifiers['uuid'])
            ->willReturn($uuidProductListIds);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getProductListIdsByKeys')
            ->with($groupedIdentifiers['key'])
            ->willReturn($keyProductListIds);

        $response = $this->reader->getIdsByGroupedIdentifier($groupedIdentifiers);

        static::assertEquals(array_merge($uuidProductListIds, $keyProductListIds), $response);
    }

    /**
     * @return void
     */
    public function testGetIdsByGroupedIdentifierWithMissingKeyIdentifier(): void
    {
        $groupedIdentifiers = [
            'uuid' => ['xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'],
            'key' => [],
        ];

        $uuidProductListIds = [
            0 => [
                'spy_product_list.uuid' => 1,
            ],
        ];

        $keyProductListIds = [];

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getProductListIdsByUuids')
            ->with($groupedIdentifiers['uuid'])
            ->willReturn($uuidProductListIds);

        $response = $this->reader->getIdsByGroupedIdentifier($groupedIdentifiers);

        static::assertEquals(array_merge($uuidProductListIds, $keyProductListIds), $response);
    }
}
