<?php

/**
 * @params string $one
 * @params string $two
 * @returns string
 */
function someFunction(string $one, string $two)
{
}

?>
-----
<?php

/**
 * @param string $one
 * @param string $two
 * @return string
 */
function someFunction(string $one, string $two)
{
}

?>
