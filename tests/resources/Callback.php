<?php
namespace TRex\Reflection\resources;

class Callback
{

    public static function bar($a, $b, $c = 3, $d = 4)
    {
        return func_get_args();
    }

    public function foo($a, $b, $c = 3, $d = 4)
    {
        return func_get_args();
    }

    public function __invoke($a, $b, $c = 3, $d = 4)
    {
        return func_get_args();
    }
}
