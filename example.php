<?php

	declare(strict_types=1);
	
	use PaquetteCodes\settingsEncoder;
	
	require_once("src/paquette-codes/SettingsEncoder.php");
	
	$example_setting = 500;
	
	echo "<pre>";
	settingsEncoder::setMaxNbConfig(10);
	$binaryString = settingsEncoder::convertToBinary($example_setting);
	
	var_dump(
		$binaryString,
		settingsEncoder::setTo($binaryString, 10, 1),
		settingsEncoder::getValue($binaryString, 40),
		settingsEncoder::convertToDecimal("11111111111111111111"), //-- max 1048575
		settingsEncoder::getIsError(),
		settingsEncoder::getErrorsMsg()
	);