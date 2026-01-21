<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Api;

use Hmh\CatalogPositionRules\Api\Data\ProductPositionRuleCategoryInterface;
use Hmh\CatalogPositionRules\Api\Data\ProductPositionRuleCategorySearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface ProductPositionRuleCategoryRepositoryInterface
{
    public function save(ProductPositionRuleCategoryInterface $ruleCategory): ProductPositionRuleCategoryInterface;

    public function getById(int $id): ProductPositionRuleCategoryInterface;

    public function getList(SearchCriteriaInterface $searchCriteria): ProductPositionRuleCategorySearchResultsInterface;

    public function getByCategoryId(int $categoryId): ?ProductPositionRuleCategoryInterface;

    public function delete(ProductPositionRuleCategoryInterface $ruleCategory): bool;

    public function deleteById(int $id): bool;
}
