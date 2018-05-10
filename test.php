<?php
class Foo
{
    public function __call($method, $args)
    {
        if (isset($this->$method)) {
            $func = $this->$method;
            return call_user_func_array($func, $args);
        }
    }
}

$foo = new Foo();
$foo->bar = function () { echo "Hello, this function is added at runtime"; };
$foo2 = new Foo();
$foo2->bar();
?>