An existing @param is incorrectly duplicated.
<?php

/**
 * @param string $one
 * @param string $one
 */
function someFunction($one, $two): void
{
}
?>
-----
An existing @param is incorrectly duplicated.
<?php

/**
 * @param string $one
 * @param string $two
 */
function someFunction($one, $two): void
{
}
?>
