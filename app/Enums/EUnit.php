<?php
namespace App\Enums;

abstract class EUnit {

    const KG = 1; //kilogram
    const PA = 2; //package
    const PCS = 3; //pcs
    
    const ARRAY_UNIT = [1, 2, 3];

    public static function valueToString($string) {
        switch ($string) {
            case EUNIT::KG:
                return 'Kg';
			case EUNIT::PA:
				return 'Package';
			case EUNIT::PCS:
				return 'PCS';
		}
		return null;
    }

    public static function stringToValue($string) {
        switch ($string) {
            case EUNIT::KG:
                return 1;
			case EUNIT::PA:
				return 2;
			case EUNIT::PCS:
				return 3;
		}
		return null;
    }
}