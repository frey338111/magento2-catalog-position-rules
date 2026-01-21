## Hmh_CatalogPositionRules

Catalog Position Rules lets admins define scoring rules and re-rank products in a category based on those rules.

### Features
- Define multiple conditions with operators and scores.
- Calculate ranking for a category and apply the new product positions.
- Optional attribute-based conditions (e.g., color) via virtual types.
- Create scored based category product position rule with multiple condition with score assigned.
- Assign rule to a category and validate products under this category with all conditions, when condition match scored is added to product accordingly.
- Products position is re-assigned to display product with highest score first, makes managing category product display with one click.

### Configuration
- Admin path: Stores > Configuration > HMH > Catalog Position Rules
- Setting: Enable/Disable module behavior

### Usage
1. Create a rule under Catalog Position Rules.
2. Open a category, select a rule, and click "Calculate Ranking".
3. Reindex if needed to see storefront updates.

### Screenshots
![enable module](images/1_enable_the_module.png)
Enable the module to show the rules fieldset on the category edit page.

![create product position rules](images/2_create_product_position_rules.png)
Create a new rule with conditions, operators, values, and scoring.

![rule contains multiple conditions](images/3_rule_contains_mutliple_conditons.png)
Combine multiple conditions in a single rule for richer scoring logic.

![assign rule and recalculate product position](images/4_assign_rule_to_category_and_recaulcuate_product_position.png)
Assign the rule to a category and run the ranking calculation.

![product position updated](images/5_produt_position_updated.png)
Review the updated product positions after calculation.

![new position applied after reindex](images/6_new_position_applied_on_fe_after_reindex.png)
Reindex and confirm the storefront shows products ordered by score.

### Add new ranking condition
1. Create a class implementing `Hmh\CatalogPositionRules\Api\RuleConditionInterface`.
2. Implement the condition logic in `isConditionMatch()`.
3. Register the class in `Hmh\CatalogPositionRules\Model\RuleConditionsPool` via `app/code/Hmh/CatalogPositionRules/etc/di.xml`.
