/*FUNCTION PENGHITUNG DENDA*/
DELIMITER $$
CREATE OR REPLACE FUNCTION hitungdenda(
	keterlambatan INT(11)
)

RETURNS INT(11)
DETERMINISTIC
BEGIN

	DECLARE total_denda INT(11);
	DECLARE denda_perhari INT(11);
	
	SELECT denda INTO denda_perhari FROM setting;
	
	SET total_denda = denda_perhari * keterlambatan;
	
	RETURN total_denda;

END$$

