<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Model;

use Hmh\CatalogPositionRules\Api\Data\ProductPositionRuleExtensionInterface;
use Hmh\CatalogPositionRules\Api\Data\ProductPositionRuleInterface;
use Hmh\CatalogPositionRules\Model\ResourceModel\ProductPositionRule as ProductPositionRuleResource;
use Magento\Framework\Model\AbstractExtensibleModel;

class ProductPositionRule extends AbstractExtensibleModel implements ProductPositionRuleInterface
{
    /**
     * Initialize model resource.
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(ProductPositionRuleResource::class);
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
    public function setId($id): ProductPositionRuleInterface
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getTitle(): ?string
    {
        return $this->getData(self::TITLE);
    }

    /**
     * @inheritDoc
     */
    public function setTitle(string $title): ProductPositionRuleInterface
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * @inheritDoc
     */
    public function getRule(): ?string
    {
        return $this->getData(self::RULE);
    }

    /**
     * @inheritDoc
     */
    public function setRule(string $rule): ProductPositionRuleInterface
    {
        return $this->setData(self::RULE, $rule);
    }

    /**
     * @inheritDoc
     */
    public function getExtensionAttributes(): ?ProductPositionRuleExtensionInterface
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * @inheritDoc
     */
    public function setExtensionAttributes(ProductPositionRuleExtensionInterface $extensionAttributes): ProductPositionRuleInterface
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
