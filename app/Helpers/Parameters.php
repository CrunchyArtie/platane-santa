<?php
namespace App\Helpers;

class Parameters
{
    public static function get($key)
    {
        $parameter = \App\Models\Parameter::where('key', $key)->first();

        if ($parameter === null) {
            return null;
        }

        switch ($parameter->type) {
            case 'boolean':
                return $parameter->value === 'true';
            case 'integer':
                return intval($parameter->value);
            case 'string':
                return $parameter->value;
            default:
                return null;
        }
    }
}
