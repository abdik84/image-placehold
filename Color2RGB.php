<?php   
Class Color2RGB {
	protected $colorList;

	function __construct() {
		$this->colorList = json_decode(file_get_contents("./color_list.json"), TRUE);
	}

	function render($color) {
		if(array_key_exists($color, $this->colorList)) 
			$hex = $this->colorList[$color];
		else 
			$hex = preg_replace("/[^0-9A-Fa-f]/", '', $color); // Gets a proper hex string

		$rgbArray = [];
		if (strlen($hex) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
			$colorVal = hexdec($hex);
			$rgbArray['R'] = 0xFF & ($colorVal >> 0x10);
			$rgbArray['G'] = 0xFF & ($colorVal >> 0x8);
			$rgbArray['B'] = 0xFF & $colorVal;
		} elseif (strlen($hex) == 3) { //if shorthand notation, need some string manipulations
			$rgbArray['R'] = hexdec(str_repeat(substr($hex, 0, 1), 2));
			$rgbArray['G'] = hexdec(str_repeat(substr($hex, 1, 1), 2));
			$rgbArray['B'] = hexdec(str_repeat(substr($hex, 2, 1), 2));
		} else 
			return false; //Invalid color	
	
		return $rgbArray;
	}
}