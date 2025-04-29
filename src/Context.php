<?php

namespace DevTheorem\Handlebars;

/**
 * @internal
 */
final class Context
{
    /**
     * @param array<mixed> $stack
     * @param array<mixed>|null $currentToken
     * @param string[] $error
     * @param array<mixed> $elseLvl
     * @param array<string, string> $usedPartial
     * @param list<string> $partialStack
     * @param array<string, string> $partialCode
     * @param array<string, true> $usedHelpers
     * @param array<mixed> $parsed
     * @param array<string, string> $partials
     * @param array<mixed> $partialBlock
     * @param array<mixed> $inlinePartial
     * @param array<string, callable> $helpers
     */
    public function __construct(
        public readonly Options $options,
        public int $level = 0,
        public array $stack = [],
        public ?array $currentToken = null,
        public array $error = [],
        public array $elseLvl = [],
        public bool $elseChain = false,
        public string $tokenSearch = '',
        public string $partialIndent = '',
        public int|false $tokenAhead = false,
        public array $usedPartial = [],
        public array $partialStack = [],
        public array $partialCode = [],
        public int $usedDynPartial = 0,
        public int $usedPBlock = 0,
        public array $usedHelpers = [],
        public bool $compile = false,
        public array $parsed = [],
        public array $partials = [],
        public ?\Closure $partials_resolver = null,
        public array $partialBlock = [],
        public array $inlinePartial = [],
        public array $helpers = [],
        public ?\Closure $helpers_resolver = null,
        public string|false $rawBlock = false,
        public readonly string $startChar = '{',
        public readonly string $separator = '.',
        public readonly string $cndStart = '.(',
        public readonly string $cndEnd = ').',
        public readonly string $cndThen = ' ? ',
        public readonly string $cndElse = ' : ',
        public readonly string $fStart = 'return ',
        public readonly string $fEnd = ';',
    ) {
        $this->partials = $options->partials;
		$this->helpers = $options->helpers;

		$this->partials_resolver = $options->partials_resolver;
		$this->helpers_resolver = $options->helpers_resolver;

        foreach ($options->helpers as $name => $func) {
            $tn = is_int($name) ? $func : $name;
            if (is_callable($func)) {
                $this->helpers[$tn] = $func;
            } else {
                if (is_array($func)) {
                    $this->error[] = "Custom helper $name must be a function, not an array.";
                } else {
                    $this->error[] = "Custom helper '$tn' must be a function.";
                }
            }
        }
    }

    /**
     * Update from another context.
     */
    public function merge(Context $context): void
    {
        $this->error = $context->error;
        $this->helpers = $context->helpers;
		$this->helpers_resolver = $context->helpers_resolver;
        $this->partials = $context->partials;
		$this->partials_resolver = $context->partials_resolver;
        $this->partialCode = $context->partialCode;
        $this->partialStack = $context->partialStack;
        $this->usedHelpers = $context->usedHelpers;
        $this->usedDynPartial = $context->usedDynPartial;
        $this->usedPBlock = $context->usedPBlock;
        $this->usedPartial = $context->usedPartial;
    }
}
