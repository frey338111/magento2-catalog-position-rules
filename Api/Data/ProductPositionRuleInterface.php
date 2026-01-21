<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface ProductPositionRuleInterface extends ExtensibleDataInterface
{
    public const ID = 'id';
    public const TITLE = 'title';
    public const RULE = 'rule';

    /**
     * Get rule ID.
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Set rule ID.
     *
     * @param mixed $id
     * @return $this
     */
    public function setId($id): self;

    /**
     * Get title.
     *
     * @return string|null
     */
    public function getTitle(): ?string;

    /**
     * Set title.
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self;

    /**
     * Get rule.
     *
     * @return string|null
     */
    public function getRule(): ?string;

    /**
     * Set rule.
     *
     * @param string $rule
     * @return $this
     */
    public function setRule(string $rule): self;
}
