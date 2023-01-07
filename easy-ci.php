<?php

declare(strict_types=1);

use Symplify\EasyCI\Config\EasyCIConfig;

return static function (EasyCIConfig $easyCIConfig): void {
    $easyCIConfig->typesToSkip([
        \Symplify\EasyCI\Config\EasyCIConfig::class,
        \Symplify\EasyCI\Contract\Application\FileProcessorInterface::class,
        \Symplify\EasyCI\Twig\TwigTemplateAnalyzer\ConstantPathTwigTemplateAnalyzer::class,
        \Symplify\EasyCI\Twig\TwigTemplateAnalyzer\MissingClassConstantTwigAnalyzer::class,
        \Symplify\EasyCI\ValueObject\ConfigFileSuffixes::class,
        \Symplify\EasyCI\Console\EasyCIApplication::class,
        \Symplify\EasyCI\Kernel\EasyCIKernel::class,
    ]);
};
