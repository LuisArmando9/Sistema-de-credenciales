<?php
namespace App\Constants;
use MyCLabs\Enum\Enum;

class Resource extends Enum
{
    //index permisions
    public const USER_INDEX = 'user.index';
    public const TOALLERA_INDEX = "toallera.index";
    public const TINTURAS_INDEX = "tinturas.index";
    public const DEPARTAMENT_INDEX = "departament.index";
    public const DENOMINTATION_INDEX = "denomination.index";
    //store permisions
    public const USER_STORE = 'user.store';
    public const TOALLERA_STORE = "toallera.store";
    public const TINTURAS_STORE = "tinturas.store";
    public const DEPARTAMENT_STORE = "departament.store";
    public const DENOMINTATION_STORE = "denomination.store";
    //destroy permisions
    public const USER_DESTROY = 'user.destroy';
    public const TOALLERA_DESTROY = "toallera.destroy";
    public const TINTURAS_DESTROY = "tinturas.destroy";
    public const DEPARTAMENT_DESTROY = "departament.destroy";
    public const DENOMINTATION_DESTROY = "denomination.destroy";
    //update permisions
    public const USER_UPDATE = 'user.update';
    public const TOALLERA_UPDATE= "toallera.update";
    public const TINTURAS_UPDATE = "tinturas.update";
    public const DEPARTAMENT_UPDATE = "departament.update";
    public const DENOMINTATION_UPDATE = "denomination.update";
    //show permisions
    public const USER_SHOW = 'user.show';
    public const TOALLERA_SHOW = "toallera.show";
    public const TINTURAS_SHOW= "tinturas.show";
    public const DEPARTAMENT_SHOW = "departament.show";
    public const DENOMINTATION_SHOW = "denomination.show";

    public static function supported(): array
    {
        return collect(static::toArray())->values()->toArray();
    }
}