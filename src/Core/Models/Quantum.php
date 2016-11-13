<?php
namespace Zjien\Quantum\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Quantum extends Model
{
    /**
     * Normalize the params.
     *
     * @param array|Model|Collection $value
     * @return array
     */
    protected static function normalize($value)
    {
        $result = [];

        if ($value instanceof Collection) {
            foreach ($value as $val) {
                $result[] = $val->getKey();
            }
        } else if ($value instanceof Model) {
            $result = [$value->getKey()];
        } else if (!is_array($value)) {
            $result = [$value];
        } else {
            $result = $value;
        }

        return $result;
    }
}