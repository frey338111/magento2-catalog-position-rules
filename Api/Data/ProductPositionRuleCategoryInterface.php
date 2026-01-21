<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface ProductPositionRuleCategoryInterface extends ExtensibleDataInterface
{
    public const ID = 'id';
    public const RULE_ID = 'rule_id';
    public const CATEGORY_ID = 'category_id';

    /**
     * Get rule category ID.
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Set rule category ID.
     *
     * @param mixed $id
     * @return $this
     */
    public function setId($id): self;

    /**
     * Get rule ID.
     *
     * @return int|null
     */
    public function getRuleId(): ?int;

    /**
     * Set rule ID.
     *
     * @param int $ruleId
     * @return $this
     */
    public function setRuleId(int $ruleId): self;

    /**
     * Get category ID.
     *
     * @return int|null
     */
    public function getCategoryId(): ?int;

    /**
     * Set category ID.
     *
     * @param int $categoryId
     * @return $this
     */
    public function setCategoryId(int $categoryId): self;
}
