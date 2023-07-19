-- KPI1a: 

DELIMITER //

DROP PROCEDURE IF EXISTS GetInnovativeIdeasCount //

CREATE PROCEDURE GetInnovativeIdeasCount()
BEGIN
  SELECT
    `quarter`,
    `idea_count`
  FROM
    `innovative_ideas`
  WHERE
    YEAR(`quarter`) = 2023
  ORDER BY `quarter`;
END //

DELIMITER ;


-- For KPI1b - Data Processing Time:
DROP PROCEDURE IF EXISTS `GetProcessingTimeForYear`;

DELIMITER $$
CREATE PROCEDURE `GetProcessingTimeForYear`()
BEGIN
  SELECT
    `quarter`,
    `processing_time`
  FROM
    `data_processing_time`
  WHERE
    YEAR(`quarter`) = 2023
  ORDER BY `quarter`;
END$$
DELIMITER ;
