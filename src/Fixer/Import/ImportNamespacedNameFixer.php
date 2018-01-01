<?php declare(strict_types=1);

namespace Symplify\CodingStandard\Fixer\Import;

use PhpCsFixer\Fixer\ConfigurationDefinitionFixerInterface;
use PhpCsFixer\Fixer\DefinedFixerInterface;
use PhpCsFixer\Fixer\FixerInterface;
use PhpCsFixer\Fixer\WhitespacesAwareFixerInterface;
use PhpCsFixer\FixerConfiguration\FixerConfigurationResolver;
use PhpCsFixer\FixerConfiguration\FixerConfigurationResolverInterface;
use PhpCsFixer\FixerConfiguration\FixerOptionBuilder;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use PhpCsFixer\WhitespacesFixerConfig;
use phpDocumentor\Reflection\DocBlock\Tag;
use phpDocumentor\Reflection\DocBlock\Tags\Param;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Types\Object_;
use SplFileInfo;
use Symplify\PackageBuilder\Reflection\PrivatesSetter;
use Symplify\TokenRunner\Analyzer\FixerAnalyzer\NamespaceFinder;
use Symplify\TokenRunner\Naming\Name\Name;
use Symplify\TokenRunner\Naming\Name\NameAnalyzer;
use Symplify\TokenRunner\Naming\Name\NameFactory;
use Symplify\TokenRunner\Naming\UseImport\UseImport;
use Symplify\TokenRunner\Naming\UseImport\UseImportsFactory;
use Symplify\TokenRunner\Wrapper\FixerWrapper\DocBlockWrapper;

/**
 * Possible cases.
 *
 * - 1. string that start with pre slash \SomeThing
 * - 2. namespace with conflicts \First\SomeClass + \Second\SomeClass
 * - 3. partial namespaces \Namespace\Partial + Partial\Class
 */
final class ImportNamespacedNameFixer implements FixerInterface, DefinedFixerInterface, ConfigurationDefinitionFixerInterface, WhitespacesAwareFixerInterface
{
    /**
     * @var string
     */
    private const ALLOW_SINGLE_NAMES_OPTION = 'allow_single_names';

    /**
     * @var int
     */
    private $namespacePosition;

    /**
     * @var UseImport[]
     */
    private $useImports = [];

    /**
     * @var mixed[]
     */
    private $configuration = [];

    /**
     * @var string
     */
    private $className;

    /**
     * @var Tokens
     */
    private $tokens;

    /**
     * @var WhitespacesFixerConfig
     */
    private $whitespacesFixerConfig;

    /**
     * @var Name[]
     */
    private $namesToAddIntoUseStatements = [];

    public function __construct()
    {
        // set defaults
        $this->configuration = $this->getConfigurationDefinition()
            ->resolve([]);
    }

    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(
            'Types should not be referenced via a fully/partially qualified name, but via a use statement.',
            [
                new CodeSample('<?php $value = \SomeNamespace\SomeClass'),
            ]
        );
    }

    public function isCandidate(Tokens $tokens): bool
    {
        return $tokens->isAllTokenKindsFound([T_CLASS, T_STRING, T_NS_SEPARATOR]) ||
            $tokens->isTokenKindFound(T_DOC_COMMENT);
    }

    public function fix(SplFileInfo $file, Tokens $tokens): void
    {
        $this->tokens = $tokens;

        $this->useImports = (new UseImportsFactory())->createForTokens($tokens);

        for ($index = $tokens->getSize() - 1; $index > 0; --$index) {
            $token = $tokens[$index];

            // class name is same as token that could be imported, skip
            if ($token->getContent() === $this->getClassName()) {
                continue;
            }

            if ($token->isGivenKind(T_DOC_COMMENT)) {
                $this->processDocCommentToken($index, $tokens);
                continue;
            }

            if ($token->isGivenKind(T_STRING)) {
                $this->processStringToken($token, $index, $tokens);
                continue;
            }
        }
    }

    /**
     * Run before:
     * - @see \PhpCsFixer\Fixer\Import\OrderedImportsFixer
     * - @see \PhpCsFixer\Fixer\Import\SingleLineAfterImportsFixer
     */
    public function getPriority(): int
    {
        return 10;
    }

    /**
     * @param mixed[]|null $configuration
     */
    public function configure(?array $configuration = null): void
    {
        if ($configuration === null) {
            return;
        }

        $this->configuration = $this->getConfigurationDefinition()
            ->resolve($configuration);
    }

    public function getConfigurationDefinition(): FixerConfigurationResolverInterface
    {
        $fixerOptionBuilder = new FixerOptionBuilder(
            self::ALLOW_SINGLE_NAMES_OPTION,
            'Whether allow \SingleClassName or import it.'
        );

        $singleNameOption = $fixerOptionBuilder->setAllowedValues([true, false])
            ->setDefault(false)
            ->getOption();

        return new FixerConfigurationResolver([$singleNameOption]);
    }

    public function supports(SplFileInfo $file): bool
    {
        return true;
    }

    /**
     * There are still some edge cases to be found and improve.
     */
    public function isRisky(): bool
    {
        return true;
    }

    public function getName(): string
    {
        return self::class;
    }

    public function setWhitespacesConfig(WhitespacesFixerConfig $whitespacesFixerConfig): void
    {
        $this->whitespacesFixerConfig = $whitespacesFixerConfig;
    }

    private function addIntoUseStatements(Tokens $tokens, Name $name): void
    {
        $namespacePosition = NamespaceFinder::findInTokens($tokens);
        $namespaceSemicolonPosition = $tokens->getNextTokenOfKind($namespacePosition, [';']);

        $tokens->insertAt($namespaceSemicolonPosition + 2, $name->getUseNameTokens());
    }

    private function wasNameImported(Name $name): bool
    {
        foreach ($this->useImports as $useImport) {
            if ($useImport->getFullName() === $name->getName()) {
                return true;
            }
        }

        $this->useImports[] = new UseImport($name->getName(), $name->getLastName());

        return false;
    }

    private function uniquateLastPart(Name $name): Name
    {
        foreach ($this->useImports as $useImport) {
            if ($useImport->getShortName() === $name->getLastName() && $useImport->getFullName() !== $name->getName()) {
                $uniquePrefix = $name->getFirstName();
                $name->addAlias($uniquePrefix . $name->getLastName());
            }
        }

        return $name;
    }

    private function getClassName(): string
    {
        if ($this->className) {
            return $this->className;
        }

        $classPosition = $this->tokens->getNextTokenOfKind(0, [new Token([T_CLASS, 'class'])]);

        $classNamePosition = $this->tokens->getNextMeaningfulToken($classPosition);

        return $this->className = $this->tokens[$classNamePosition]->getContent();
    }

    private function processStringToken(Token $token, int $index, Tokens $tokens): void
    {
        // Case 1.
        if (! NameAnalyzer::isImportableNameToken($tokens, $token, $index)) {
            return;
        }

        $name = NameFactory::createFromTokensAndEnd($tokens, $index);
        if ($this->configuration[self::ALLOW_SINGLE_NAMES_OPTION] && $name->isSingleName()) {
            return;
        }

        $name = $this->uniquateLastPart($name);

        // replace with last name part
        $tokens->overrideRange($name->getStart(), $name->getEnd(), [$name->getLastNameToken()]);

        // has this been already imported?
        if ($this->wasNameImported($name)) {
            return;
        }

        if ($name->isPartialName()) {
            // add use statement
            $this->addIntoUseStatements($tokens, $name);

            return;
        }

        // add use statement
        $this->addIntoUseStatements($tokens, $name);
    }

    private function processDocCommentToken(int $index, Tokens $tokens): void
    {
        $docBlockWrapper = DocBlockWrapper::createFromTokensAndPosition($tokens, $index);
        // require for doc block changes
        $docBlockWrapper->setWhitespacesFixerConfig($this->whitespacesFixerConfig);
        $this->processParamsTags($docBlockWrapper, $index, $tokens);
        $this->processReturnTag($docBlockWrapper, $index, $tokens);

        // save doc comment
        $docBlockContent = $docBlockWrapper->getContent();
        $this->tokens[$index] = new Token([T_DOC_COMMENT, $docBlockContent]);

        $this->namesToAddIntoUseStatements = array_unique($this->namesToAddIntoUseStatements, SORT_REGULAR);

        foreach ($this->namesToAddIntoUseStatements as $nameToAddIntoUseStatement) {
            $this->addIntoUseStatements($tokens, $nameToAddIntoUseStatement);
        }

        // @todo: process @var tag
    }

    private function processReturnTag(DocBlockWrapper $docBlockWrapper, int $index, Tokens $tokens): void
    {
        $returnTag = $docBlockWrapper->getReturnTag();
        if (! $returnTag) {
            return;
        }

        $fullName = $this->shortenNameAndReturnFullName($returnTag);
        if (! $fullName) {
            return;
        }

        // add use statement
        $this->namesToAddIntoUseStatements[] = NameFactory::createFromStringAndTokens($fullName, $tokens);
    }

    private function processParamsTags(DocBlockWrapper $docBlockWrapper, int $index, Tokens $tokens): void
    {
        foreach ($docBlockWrapper->getParamTags() as $paramTag) {
            $fullName = $this->shortenNameAndReturnFullName($paramTag);
            if (! $fullName) {
                return;
            }

            // add use statement
            $this->namesToAddIntoUseStatements[] = NameFactory::createFromStringAndTokens($fullName, $tokens);
        }
    }

    /**
     * @param Param $tag
     */
    private function shortenNameAndReturnFullName(Tag $tag): ?string
    {
        /** @var Object_ $objectType */
        $objectType = $tag->getType();

        $usedName = (string) $objectType->getFqsen();
        $lastName = $objectType->getFqsen()->getName();

        if ($lastName === ltrim($usedName, '\\')) {
            return null;
        }

        // set new short name
        (new PrivatesSetter())->setPrivateProperty($objectType, 'fqsen', new Fqsen('\\' . $lastName));

        return $usedName;
    }
}
