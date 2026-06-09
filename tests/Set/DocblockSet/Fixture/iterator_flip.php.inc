<?php

function test($value): string
{
    /* @var $value Iterator<SomeType> */
    return $value;
}

?>
-----
<?php

function test($value): string
{
    /** @var Iterator<SomeType> $value */
    return $value;
}

?>
