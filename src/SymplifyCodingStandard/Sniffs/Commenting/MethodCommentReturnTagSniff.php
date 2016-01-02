<?php

/**
 * This file is part of Symplify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace SymplifyCodingStandard\Sniffs\Commenting;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;
use SymplifyCodingStandard\Helper\Commenting\MethodDocBlock;

/**
 * Rules:
 * - Getters should have @return tag (except for {@inheritdoc}).
 */
final class MethodCommentReturnTagSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * @var string[]
     */
    private $getterMethodPrefixes = ['get', 'is', 'has', 'will', 'should'];

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        return [T_FUNCTION];
    }

    /**
     * {@inheritdoc}
     */
    public function process(PHP_CodeSniffer_File $file, $position)
    {
        $methodName = $file->getDeclarationName($position);
        $isGetterMethod = $this->guessIsGetterMethod($methodName);
        if ($isGetterMethod === false) {
            return;
        }

        $methodDocBlockHelper = new MethodDocBlock();

        if ($methodDocBlockHelper->hasMethodDocBlock($file, $position) === false) {
            $file->addError('Getters should have docblock.', $position);

            return;
        }

        $commentString = $methodDocBlockHelper->getMethodDocBlock($file, $position);

        if (strpos($commentString, '{@inheritdoc}') !== false) {
            return;
        }

        if (strpos($commentString, '@return') !== false) {
            return;
        }

        $file->addError('Getters should have @return tag (except {@inheritdoc}).', $position);
    }

    /**
     * @param string $methodName
     *
     * @return bool
     */
    private function guessIsGetterMethod($methodName)
    {
        foreach ($this->getterMethodPrefixes as $getterMethodPrefix) {
            if (strpos($methodName, $getterMethodPrefix) === 0) {
                if (strlen($methodName) === strlen($getterMethodPrefix)) {
                    return true;
                }

                $endPosition = strlen($getterMethodPrefix);
                $firstLetterAfterGetterPrefix = $methodName[$endPosition];

                if (ctype_upper($firstLetterAfterGetterPrefix)) {
                    return true;
                }
            }
        }

        return false;
    }
}
