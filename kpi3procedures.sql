-- kpi3a
DROP PROCEDURE IF EXISTS `GetPatientSatisfactionScores`;

DELIMITER $$
CREATE PROCEDURE `GetPatientSatisfactionScores`(IN targetScore DECIMAL(3,1))
BEGIN
  SELECT
    `id`,
    `satisfaction_score`
  FROM
    `patient_satisfaction`
  WHERE
    `satisfaction_score` >= targetScore;
END$$
DELIMITER ;




-- kpi3b
DROP PROCEDURE IF EXISTS `GetSuccessfulInterventions`;

DELIMITER $$
CREATE PROCEDURE `GetSuccessfulInterventions`(IN targetCount INT)
BEGIN
  SELECT
    `quarter`,
    `intervention_count`
  FROM
    `interventions`
  WHERE
    `intervention_count` >= targetCount;
END$$
DELIMITER ;
