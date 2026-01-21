<?php

namespace Hmh\CatalogPositionRules\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ProductPositionRuleSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get product position rule items.
     *
     * @return ProductPositionRuleInterface[]
     */
    public function getItems();

    /**
     * Set product position rule items.
     *
     * @param ProductPositionRuleInterface[] $items
     */
    public function setItems(array $items);
}
