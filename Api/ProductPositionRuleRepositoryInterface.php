<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Api;

use Hmh\CatalogPositionRules\Api\Data\ProductPositionRuleInterface;
use Hmh\CatalogPositionRules\Api\Data\ProductPositionRuleSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface ProductPositionRuleRepositoryInterface
{
    /**
     * Save rule.
     *
     * @param ProductPositionRuleInterface $rule
     * @return ProductPositionRuleInterface
     */
    public function save(ProductPositionRuleInterface $rule): ProductPositionRuleInterface;

    /**
     * Get rule by ID.
     *
     * @param int $id
     * @return ProductPositionRuleInterface
     */
    public function getById(int $id): ProductPositionRuleInterface;

    /**
     * Get rules list.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return ProductPositionRuleSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): ProductPositionRuleSearchResultsInterface;

    /**
     * Delete rule.
     *
     * @param ProductPositionRuleInterface $rule
     * @return bool
     */
    public function delete(ProductPositionRuleInterface $rule): bool;

    /**
     * Delete rule by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;
}
