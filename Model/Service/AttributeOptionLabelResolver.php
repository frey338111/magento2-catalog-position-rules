<?php
declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Model\Service;

use Magento\Catalog\Api\Data\ProductInterface;

class AttributeOptionLabelResolver
{
    public function resolve(ProductInterface $product, string $attributeCode, mixed $attributeValue): mixed
    {
        $attribute = $product->getResource()->getAttribute($attributeCode);
        if (!$attribute || !$attribute->usesSource()) {
            return $attributeValue;
        }

        $optionText = $attribute->getSource()->getOptionText($attributeValue);
        if (is_array($optionText)) {
            return $optionText;
        }
        if ($optionText !== false && $optionText !== null) {
            return $optionText;
        }

        return $attributeValue;
    }
}
