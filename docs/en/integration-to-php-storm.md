# Integration to PhpStorm
 
See [JetBrains manual](http://confluence.jetbrains.com/display/PhpStorm/PHP+Code+Sniffer+in+PhpStorm#PHPCodeSnifferinPhpStorm-InstallingviaComposer) or simply:

1. Project Settings | PHP | Code Sniffer - define path to `vendor\bin\phpcs`, try validate
2. Project Settings | Inspections - PHP, tick *PHP Code Sniffer validation*
3. In the right corner of the window, pick *Custom*
4. In the end of the line click *...* button
5. Select path to dir with ruleset.xml `vendor/symplify/coding-standard/src/SymplifyCodingStandard`
6. Apply, OK
7. Restart PhpStorm
8. Profit!
