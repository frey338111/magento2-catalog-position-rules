<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Model;

use Hmh\CatalogPositionRules\Api\Data\ProductPositionRuleSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

class ProductPositionRuleSearchResults extends SearchResults implements ProductPositionRuleSearchResultsInterface
{
}
