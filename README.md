# Settings Encoder

Little simple class to compact values of switches in your configurations application into an integer instead of creating collumns in your DB or JSON file per example.

We often use in a form the 'checkbox' html tag like per example:
```html
<div class="form-check">
    <input class="form-check-input" type="checkbox" name="pos1" value="1" id="defaultCheck1">
    <label class="form-check-label" for="defaultCheck1">
        is live
    </label>
</div>
```
```html
<div class="form-check form-switch">
  <input class="form-check-input" type="checkbox" name="pos1" value="1" role="switch" id="flexSwitchCheckChecked" checked>
  <label class="form-check-label" for="flexSwitchCheckChecked">is Live</label>
</div>
```

We now have to check the value from the form and set if it's checked (1) or not (0) and send it into the binary array at the proper position.

## Simple example #1:
Set to 1 the 10th configuration.
```php
//-- Require the class
require_once("src/paquette-codes/SettingsEncoder.php");

//-- Use this namespace
use PaquetteCodes\settingsEncoder;

//-- Use the integer 13 as an example.
//-- by default, you can go to maximum 1048575 (20 binary String).
//-- 13 in binary on a 20 string = '00000000000000001101'
$example_setting = 13;

//-- to set to 1 the 10th setting.
//-- the binary String then will be : '00000000001000001101'
$bin = settingsEncoder::setTo($example_setting, 10, 1);
// to set to 0 -> $bin = settingsEncoder::setTo($example_setting, 10, 0);

//-- to get the decimal of this binary string
//-- in order to save it in a DB, JSON, etc per example.
$decimal = settingsEncoder::convertToDecimal($bin);
```

## Simple example #2:
Getting the value (0 or 1) of a configuration. Let's take configuration #3 per example.
```php
require_once("src/paquette-codes/SettingsEncoder.php");
use PaquetteCodes\settingsEncoder;

$example_setting = 13;

//-- we want to know to value of setting #3 
$value = settingsEncoder::getValue($binaryString, 3),

//-- $value value will be '1' in string.
//-- if there is an error, $value could be ''.
//-- You can use getIsError() to know if there is an error.
//-- if you want to know the detail of the error, use getErrorsMsg()
$boolError = settingsEncoder::getIsError();
$arrayErrorsMsg = settingsEncoder::getErrorsMsg();
```
## Simple example #3:
Setting the maximum number of configuration switch position.
Usefull when you want to limit the saved integer.
```php
require_once("src/paquette-codes/SettingsEncoder.php");
use PaquetteCodes\settingsEncoder;

settingsEncoder::setMaxNbConfig(10);
//-- 10 positions (1111111111) in the binary instead of the default of 20 (11111111111111111111).
//-- so the highest decimal number will be 1023 instead of 1048575.
//-- important : Set this at the begining since it's used in others methods too!
```

## Error messages:
Several types of error could be generated... Here's some example:
- When the initial decimal value is bigger than the maximum binary allowed (by default, it's 20 positions in the binary string, so 1048575).
- When a position is greater than the maximum of positions in the binary string ( when using getValue() & setTo() ).

---
### License
This project is licensed under the MIT License. See LICENSE for further information.
