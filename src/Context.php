<?php
/*

MIT License
Copyright 2013-2021 Zordius Chen. All Rights Reserved.
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

Origin: https://github.com/zordius/lightncandy
*/

/**
 * file to handle LightnCandy Context
 *
 * @package    LightnCandy
 * @author     Zordius <zordius@gmail.com>
 */

namespace LightnCandy;

/**
 * LightnCandy class to handle Context
 */
class Context extends Flags
{
    /**
     * Create a context from options
     *
     * @param array<string,array|string|integer> $options input options
     *
     * @return array<string,array|string|integer> Context from options
     */
    public static function create($options)
    {
        if (!is_array($options)) {
            $options = array();
        }

        $flags = $options['flags'] ?? 0;

        $context = array(
            'flags' => array(
                'errorlog' => $flags & static::FLAG_ERROR_LOG,
                'exception' => $flags & static::FLAG_ERROR_EXCEPTION,
                'noesc' => $flags & static::FLAG_NOESCAPE,
                'spvar' => $flags & static::FLAG_SPVARS,
                'slash' => $flags & static::FLAG_SLASH,
                'else' => $flags & static::FLAG_ELSE,
                'lambda' => $flags & static::FLAG_HANDLEBARSLAMBDA,
                'noind' => $flags & static::FLAG_PREVENTINDENT,
                'debug' => $flags & static::FLAG_RENDER_DEBUG,
                'prop' => $flags & static::FLAG_PROPERTY,
                'runpart' => $flags & static::FLAG_RUNTIMEPARTIAL,
                'partnc' => $flags & static::FLAG_PARTIALNEWCONTEXT,
                'nostd' => $flags & static::FLAG_IGNORESTANDALONE,
                'strpar' => $flags & static::FLAG_STRINGPARAMS,
                'knohlp' => $flags & static::FLAG_KNOWNHELPERSONLY,
            ),
            'delimiters' => array(
                isset($options['delimiters'][0]) ? $options['delimiters'][0] : '{{',
                isset($options['delimiters'][1]) ? $options['delimiters'][1] : '}}',
            ),
            'level' => 0,
            'stack' => array(),
            'currentToken' => null,
            'error' => array(),
            'elselvl' => array(),
            'elsechain' => false,
            'tokens' => array(
                'standalone' => true,
                'ahead' => false,
                'current' => 0,
                'count' => 0,
                'partialind' => '',
            ),
            'usedPartial' => array(),
            'partialStack' => array(),
            'partialCode' => array(),
            'usedFeature' => array(
                'rootthis' => 0,
                'enc' => 0,
                'raw' => 0,
                'sec' => 0,
                'isec' => 0,
                'if' => 0,
                'else' => 0,
                'unless' => 0,
                'each' => 0,
                'this' => 0,
                'parent' => 0,
                'with' => 0,
                'comment' => 0,
                'partial' => 0,
                'dynpartial' => 0,
                'inlpartial' => 0,
                'helper' => 0,
                'delimiter' => 0,
                'subexp' => 0,
                'rawblock' => 0,
                'pblock' => 0,
                'lookup' => 0,
                'log' => 0,
            ),
            'usedCount' => array(
                'var' => array(),
                'helpers' => array(),
                'runtime' => array(),
            ),
            'compile' => false,
            'parsed' => array(),
            'partials' => (isset($options['partials']) && is_array($options['partials'])) ? $options['partials'] : array(),
            'partialblock' => array(),
            'inlinepartial' => array(),
            'helpers' => array(),
            'renderex' => isset($options['renderex']) ? $options['renderex'] : '',
            'prepartial' => (isset($options['prepartial']) && is_callable($options['prepartial'])) ? $options['prepartial'] : false,
            'partialresolver' => (isset($options['partialresolver']) && is_callable($options['partialresolver'])) ? $options['partialresolver'] : false,
            'runtime' => isset($options['runtime']) ? $options['runtime'] : '\\LightnCandy\\Runtime',
            'runtimealias' => 'LR',
            'safestring' => '\\LightnCandy\\SafeString',
            'safestringalias' => isset($options['safestring']) ? $options['safestring'] : 'LS',
            'rawblock' => false,
            'funcprefix' => uniqid('lcr'),
        );

        $context['ops'] = array(
            'seperator' => '.',
            'f_start' => 'return ',
            'f_end' => ';',
            'op_start' => 'return ',
            'op_end' => ';',
            'cnd_start' => '.(',
            'cnd_then' => ' ? ',
            'cnd_else' => ' : ',
            'cnd_end' => ').',
            'cnd_nend' => ')',
        );

        $context['ops']['enc'] = 'encq';
        $context['ops']['array_check'] = '$inary=is_array($in);';
        static::updateHelperTable($context, $options);

        if ($context['flags']['partnc'] && ($context['flags']['runpart'] == 0)) {
            $context['error'][] = 'The FLAG_PARTIALNEWCONTEXT requires FLAG_RUNTIMEPARTIAL! Fix your compile options please';
        }

        return $context;
    }

    /**
     * update specific custom helper table from options
     *
     * @param array<string,array|string|integer> $context prepared context
     * @param array<string,array|string|integer> $options input options
     * @param string $tname helper table name
     *
     * @return array<string,array|string|integer> context with generated helper table
     *
     * @expect array() when input array(), array()
     * @expect array('error' => array('You provide a custom helper named as \'abc\' in options[\'helpers\'], but the function abc() is not defined!'), 'flags' => array()) when input array('error' => array(), 'flags' => array()), array('helpers' => array('abc'))
     * @expect array('flags' => array(), 'helpers' => array('\\LightnCandy\\Runtime::raw' => '\\LightnCandy\\Runtime::raw')) when input array('flags' => array(), 'helpers' => array()), array('helpers' => array('\\LightnCandy\\Runtime::raw'))
     * @expect array('flags' => array(), 'helpers' => array('test' => '\\LightnCandy\\Runtime::raw')) when input array('flags' => array(), 'helpers' => array()), array('helpers' => array('test' => '\\LightnCandy\\Runtime::raw'))
     */
    protected static function updateHelperTable(&$context, $options, $tname = 'helpers')
    {
        if (isset($options[$tname]) && is_array($options[$tname])) {
            foreach ($options[$tname] as $name => $func) {
                $tn = is_int($name) ? $func : $name;
                if (is_callable($func)) {
                    $context[$tname][$tn] = $func;
                } else {
                    if (is_array($func)) {
                        $context['error'][] = "I found an array in $tname with key as $name, please fix it.";
                    } else {
                        $context['error'][] = "You provide a custom helper named as '$tn' in options['$tname'], but the function $func() is not defined!";
                    }
                }
            }
        }
        return $context;
    }

    /**
     * Merge a context into another
     *
     * @param array<string,array|string|integer> $context master context
     * @param array<string,array|string|integer> $tmp another context will be overwrited into master context
     */
    public static function merge(&$context, $tmp)
    {
        $context['error'] = $tmp['error'];
        $context['helpers'] = $tmp['helpers'];
        $context['partials'] = $tmp['partials'];
        $context['partialCode'] = $tmp['partialCode'];
        $context['partialStack'] = $tmp['partialStack'];
        $context['usedCount'] = $tmp['usedCount'];
        $context['usedFeature'] = $tmp['usedFeature'];
        $context['usedPartial'] = $tmp['usedPartial'];
    }
}
