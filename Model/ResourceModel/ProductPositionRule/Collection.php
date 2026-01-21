<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Model\ResourceModel\ProductPositionRule;

use Hmh\CatalogPositionRules\Model\ProductPositionRule as ProductPositionRuleModel;
use Hmh\CatalogPositionRules\Model\ResourceModel\ProductPositionRule as ProductPositionRuleResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct(): void
    {
        $this->_init(ProductPositionRuleModel::class, ProductPositionRuleResource::class);
    }
}
