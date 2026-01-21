<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Api;

use Hmh\CatalogPositionRules\Api\Data\ProductPositionRuleInterface;
use Hmh\CatalogPositionRules\Api\Data\ProductPositionRuleSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface ProductPositionRuleRepositoryInterface
{
    public function save(ProductPositionRuleInterface $rule): ProductPositionRuleInterface;

    public function getById(int $id): ProductPositionRuleInterface;

    public function getList(SearchCriteriaInterface $searchCriteria): ProductPositionRuleSearchResultsInterface;

    public function delete(ProductPositionRuleInterface $rule): bool;

    public function deleteById(int $id): bool;
}
