<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Api;

use Hmh\CatalogPositionRules\Api\Data\ProductPositionRuleCategoryInterface;
use Hmh\CatalogPositionRules\Api\Data\ProductPositionRuleCategorySearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface ProductPositionRuleCategoryRepositoryInterface
{
    /**
     * Save rule category.
     *
     * @param ProductPositionRuleCategoryInterface $ruleCategory
     * @return ProductPositionRuleCategoryInterface
     */
    public function save(ProductPositionRuleCategoryInterface $ruleCategory): ProductPositionRuleCategoryInterface;

    /**
     * Get rule category by ID.
     *
     * @param int $id
     * @return ProductPositionRuleCategoryInterface
     */
    public function getById(int $id): ProductPositionRuleCategoryInterface;

    /**
     * Get rule categories list.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return ProductPositionRuleCategorySearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): ProductPositionRuleCategorySearchResultsInterface;

    /**
     * Get rule category by category ID.
     *
     * @param int $categoryId
     * @return ProductPositionRuleCategoryInterface|null
     */
    public function getByCategoryId(int $categoryId): ?ProductPositionRuleCategoryInterface;

    /**
     * Delete rule category.
     *
     * @param ProductPositionRuleCategoryInterface $ruleCategory
     * @return bool
     */
    public function delete(ProductPositionRuleCategoryInterface $ruleCategory): bool;

    /**
     * Delete rule category by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;
}
