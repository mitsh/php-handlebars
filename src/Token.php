<?php

namespace DevTheorem\Handlebars;

/**
 * @internal
 */
final class Token
{
    // RegExps
    public const VARNAME_SEARCH = '/(\\[[^\\]]+\\]|[^\\[\\]\\.]+)/';

    // Positions of matched token
    public const POS_LOTHER = 1;
    public const POS_LSPACE = 2;
    public const POS_BEGINTAG = 3;
    public const POS_LSPACECTL = 4;
    public const POS_BEGINRAW = 5;
    public const POS_OP = 6;
    public const POS_INNERTAG = 7;
    public const POS_ENDRAW = 8;
    public const POS_RSPACECTL = 9;
    public const POS_ENDTAG = 10;
    public const POS_RSPACE = 11;
    public const POS_ROTHER = 12;
    public const POS_BACKFILL = 13;

    /**
     * Setup delimiter by default or provided string
     *
     * @param array<string,array|string|int> $context Current context
     */
    public static function setDelimiter(array &$context): void
    {
        $left = '{{';
        $right = '}}';
        $context['tokens']['startchar'] = substr($left, 0, 1);
        $context['tokens']['left'] = $left;
        $context['tokens']['right'] = $right;
        $rawcount = $context['rawblock'] ? '{2}' : '{0,2}';
        $left = preg_quote($left);
        $right = preg_quote($right);

        $context['tokens']['search'] = "/^(.*?)(\\s*)($left)(~?)(\\{{$rawcount})\\s*([\\^#\\/!&>\\*]{0,2})(.*?)\\s*(\\}{$rawcount})(~?)($right)(\\s*)(.*)\$/s";
    }

    /**
     * Return whole token string
     *
     * @param string[] $token detected handlebars {{ }} token
     * @param string[]|null $merge list of token strings to be merged
     */
    public static function toString(array $token, ?array $merge = null): string
    {
        if (is_array($merge)) {
            $token = array_replace($token, $merge);
        }
        return implode('', array_slice($token, 3, -2));
    }
}
