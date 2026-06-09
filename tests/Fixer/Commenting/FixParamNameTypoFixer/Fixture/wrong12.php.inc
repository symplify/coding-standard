Wrong @param name is a substring of another param.
<?php

/**
 * @param string $foooo
 * @param string $fooooo
 * @param string $foooooo
 */
function someFunction($foo, $fooo): void
{
}
?>
-----
Wrong @param name is a substring of another param.
<?php

/**
 * @param string $foo
 * @param string $fooo
 * @param string $foooooo
 */
function someFunction($foo, $fooo): void
{
}
?>
