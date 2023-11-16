<?php
	
	/**
	 * Class to encode boolean values (per example, from an checkbox form in configuration page)
	 * into an decimal value.
	 *
	 * author : paquette-codes
	 * Version 1.00 - 20231115
	 */
	
	declare(strict_types=1);
	
	namespace PaquetteCodes;
	
	class settingsEncoder
	{
		private static int   $maxNbConfig = 20; //-- nb of configuration switch by default
		private static bool  $isError     = FALSE;
		private static array $error       = [];
		
		/**
		 * convert to binary string a decimal value.
		 * ex: 10 = 1010
		 *
		 * @param int $decimal
		 * @return string
		 */
		public static function convertToBinary(int $decimal): string
		{
			$maxDecinalValue = self::convertToDecimal(str_pad("1", self::$maxNbConfig, "1", STR_PAD_LEFT));
			if ($maxDecinalValue < $decimal) {
				self::$error['convertToBinary'] = "Decimal value '" . $decimal . "' could not be greater than " . $maxDecinalValue;
				self::$isError                  = TRUE;
				return '0';
			}
			return self::_getPaddedBinaryString(decbin($decimal));
		}
		
		/**
		 * convert back to decimal value, a binary string.
		 * ex: 1101 = 13
		 *
		 * @param string $binary
		 * @return int
		 */
		public static function convertToDecimal(string $binary): int
		{
			if (strlen($binary) > self::$maxNbConfig) {
				self::$error['convertToDecimal'] = "Binary string length '" . $binary . "' could not be greater than " . self::$maxNbConfig;
				self::$isError                   = TRUE;
				return 0;
			}
			return (int)bindec($binary);
		}
		
		/**
		 * pad a binary string to the max number of 0 from a binary string
		 * ex: 1101 = 00000000000000001101 when $maxNbConfig = 20.
		 * @param string $binary
		 * @return string
		 */
		private static function _getPaddedBinaryString(string $binary): string
		{
			return str_pad($binary, self::$maxNbConfig, "0", STR_PAD_LEFT);
		}
		
		/**
		 * set a binary switch to $int.
		 *    $bin is the binary switch to use.
		 *    $pos is the position started from the right.
		 *    $int must be 0 or 1.
		 *
		 * if error:
		 *    $iserror is set to true.
		 *    $error got a new error message into his array.
		 *    $bin is returned unchaged
		 *
		 * @param string $bin
		 * @param int $pos
		 * @param int $int
		 * @return string
		 */
		public static function setTo(string $binary, int $pos, int $int): string
		{
			if ($int < 0 || $int > 1) {
				self::$error['setTo'] = "'value #3' must be 0 or 1";
				self::$isError        = TRUE;
				return $binary;
			}
			if (abs($pos) > self::$maxNbConfig) {
				self::$error['setTo'] = "'value #2' must be betwwen 1 and " . self::$maxNbConfig;
				self::$isError        = TRUE;
				return $binary;
			}
			
			$int = (string)$int;
			return (string)substr_replace($binary, $int, -abs($pos), 1);
		}
		
		/**
		 * get the errors messages. return empty array when no message.
		 *
		 * @return array
		 */
		public static function getErrorsMsg(): array
		{
			return self::$error;
		}
		
		/**
		 * get true|flase when they are at least one message in the error array
		 *
		 * @return bool
		 */
		public static function getIsError(): bool
		{
			return self::$isError;
		}
		
		/**
		 * set the number of switch (0|1) in the binary string.
		 * if set to 10 per example, we will have 10 switch that we can use.
		 * by default, it's 20.
		 *
		 * @param int $maxNbConfig
		 * @return void
		 */
		public static function setMaxNbConfig(int $maxNbConfig): void
		{
			self::$maxNbConfig = $maxNbConfig;
		}
		
		public static function getValue(string $binary, int $pos): string
		{
			if (abs($pos) > self::$maxNbConfig) {
				self::$error['getValue'] = "'value #2' must be betwwen 1 and " . self::$maxNbConfig;
				self::$isError           = TRUE;
				return '';
			}
			
			return substr($binary, -$pos, 1);
		}
	}
	
	//-- ---------------------------------------------------------------
	//-- ---------------------------------------------------------------
	//-- ---------------------------------------------------------------
	//-- ---------------------------------------------------------------
	//-- ---------------------------------------------------------------