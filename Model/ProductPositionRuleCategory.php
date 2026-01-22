<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Model;

use Hmh\CatalogPositionRules\Api\Data\ProductPositionRuleCategoryExtensionInterface;
use Hmh\CatalogPositionRules\Api\Data\ProductPositionRuleCategoryInterface;
use Hmh\CatalogPositionRules\Model\ResourceModel\ProductPositionRuleCategory as ProductPositionRuleCategoryResource;
use Magento\Framework\Model\AbstractExtensibleModel;

class ProductPositionRuleCategory extends AbstractExtensibleModel implements ProductPositionRuleCategoryInterface
{
    /**
     * Initialize model resource.
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(ProductPositionRuleCategoryResource::class);
    }

    /**
     * @inheritDoc
     */
    public function getId(): ?int
    {
        $value = $this->getData(self::ID);
        return $value === null ? null : (int)$value;
    }

    /**
     * @inheritDoc
     */
    public function setId($id): ProductPositionRuleCategoryInterface
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getRuleId(): ?int
    {
        $value = $this->getData(self::RULE_ID);
        return $value === null ? null : (int)$value;
    }

    /**
     * @inheritDoc
     */
    public function setRuleId(int $ruleId): ProductPositionRuleCategoryInterface
    {
        return $this->setData(self::RULE_ID, $ruleId);
    }

    /**
     * @inheritDoc
     */
    public function getCategoryId(): ?int
    {
        $value = $this->getData(self::CATEGORY_ID);
        return $value === null ? null : (int)$value;
    }

    /**
     * @inheritDoc
     */
    public function setCategoryId(int $categoryId): ProductPositionRuleCategoryInterface
    {
        return $this->setData(self::CATEGORY_ID, $categoryId);
    }

    /**
     * @inheritDoc
     */
    public function getExtensionAttributes(): ?ProductPositionRuleCategoryExtensionInterface
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * @inheritDoc
     */
    public function setExtensionAttributes(
        ProductPositionRuleCategoryExtensionInterface $extensionAttributes
    ): ProductPositionRuleCategoryInterface
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
