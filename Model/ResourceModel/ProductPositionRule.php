<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ProductPositionRule extends AbstractDb
{
    protected function _construct(): void
    {
        $this->_init('hmh_product_position_rules', 'id');
    }
}
