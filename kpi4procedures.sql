-- kpi4a
DROP PROCEDURE IF EXISTS `GetCostSavings`;

DELIMITER $$
CREATE PROCEDURE `GetCostSavings`(IN targetSavings DECIMAL(10,2))
BEGIN
  SELECT
    `quarter`,
    `cost_savings`
  FROM
    `cost_savings`
  WHERE
    `cost_savings` >= targetSavings;
END$$
DELIMITER ;

-- kpi4b
-- For KPI4b - Reduction in Hospitalizations and Healthcare Expenditures associated with Cardiovascular Diseases:
DROP PROCEDURE IF EXISTS `GetReductionData`;

DELIMITER $$
CREATE PROCEDURE `GetReductionData`()
BEGIN
  SELECT
    CONCAT(`category`, ' - ', `subcategory`) AS `category_subcategory`,
    `hospitalizations`,
    `expenditures`
  FROM
    `reductions`;
END$$
DELIMITER ;

