-- kpi2a
DROP PROCEDURE IF EXISTS `GetDataProcessingTimePerPatient`;

DELIMITER $$
CREATE PROCEDURE `GetDataProcessingTimePerPatient`(IN currentYear INT)
BEGIN
  SELECT
    CONCAT(`age`, ' (', `gender`, ')') AS `patient_info`,
    AVG(`processing_time`) AS `avg_processing_time`
  FROM
    `patient_data`
  WHERE
    YEAR(`year`) = currentYear
  GROUP BY `patient_info`
  ORDER BY `avg_processing_time` DESC;
END$$
DELIMITER ;


-- kpi2b
DELIMITER //

DROP PROCEDURE IF EXISTS `GetDataErrorsAndInconsistencies` //

CREATE PROCEDURE `GetDataErrorsAndInconsistencies`(IN currentYear INT)
BEGIN
  SELECT
    `month`,
    `data_errors`
  FROM
    `data_errors`
  WHERE
    YEAR(`year`) = currentYear
  ORDER BY `month`;
END //

DELIMITER ;
