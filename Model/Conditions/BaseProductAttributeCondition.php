<?php
declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Model\Conditions;

use Hmh\CatalogPositionRules\Api\RuleConditionInterface;
use Hmh\CatalogPositionRules\Model\Data\ConditionInfoDto;
use Hmh\CatalogPositionRules\Model\Service\AttributeOptionLabelResolver;
use Magento\Catalog\Api\Data\ProductInterface;

class BaseProductAttributeCondition implements RuleConditionInterface
{
    /**
     * @param string $label
     * @param string $tag
     * @param string $attributeCode
     * @param AttributeOptionLabelResolver $attributeOptionLabelResolver
     */
    public function __construct(
        private readonly string $label,
        private readonly string $tag,
        private readonly string $attributeCode,
        private readonly AttributeOptionLabelResolver $attributeOptionLabelResolver
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @inheritDoc
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * @inheritDoc
     */
    public function isConditionMatch(ProductInterface $product, ConditionInfoDto $condition): bool
    {
        $attributeValue = null;
        $customAttribute = $product->getCustomAttribute($this->attributeCode);
        if ($customAttribute !== null) {
            $attributeValue = $customAttribute->getValue();
        } elseif (method_exists($product, 'getData')) {
            $attributeValue = $product->getData($this->attributeCode);
        }
        if (is_null($attributeValue)) {
            return false;
        }

        $targetValue = (string)$condition->getTargetValue();
        $attributeValue = $this->attributeOptionLabelResolver->resolve(
            $product,
            $this->attributeCode,
            $attributeValue
        );
        $normalizedTarget = strtolower($targetValue);
        $isMatch = false;
        if (is_array($attributeValue)) {
            foreach ($attributeValue as $value) {
                if (strtolower((string)$value) === $normalizedTarget) {
                    $isMatch = true;
                    break;
                }
            }
        } else {
            $isMatch = strtolower((string)$attributeValue) === $normalizedTarget;
        }
        return $isMatch;
    }
}
