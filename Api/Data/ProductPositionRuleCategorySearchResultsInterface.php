<?php

namespace Hmh\CatalogPositionRules\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ProductPositionRuleCategorySearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get product position rule category items.
     *
     * @return ProductPositionRuleCategoryInterface[]
     */
    public function getItems();

    /**
     * Set product position rule category items.
     *
     * @param ProductPositionRuleCategoryInterface[] $items
     */
    public function setItems(array $items);
}
