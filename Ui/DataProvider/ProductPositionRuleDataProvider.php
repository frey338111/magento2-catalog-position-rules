<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Ui\DataProvider;

use Hmh\CatalogPositionRules\Model\ResourceModel\ProductPositionRule\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

class ProductPositionRuleDataProvider extends AbstractDataProvider
{
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
}
