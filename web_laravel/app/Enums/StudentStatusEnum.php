<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class StudentStatusEnum extends Enum
{
    public const DANG_HOC =   1;
    public const BO_HOC =   2;
    public const BAO_LUU = 3;
    public static function getArrayStatus(){
        return [
            'đang học' => self::DANG_HOC,
            'nghỉ học' => self::BO_HOC,
            'bảo luu' => self::BAO_LUU,
        ];
    }
    public static function  getKeyByValue($value) : string
    {
        return array_search($value,self::getArrayStatus(),true);
    }
}
