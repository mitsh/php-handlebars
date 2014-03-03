<?php
/**
 * Generated by build/gen_test on 2014-02-26 at 05:34:15.
 */
require_once('src/lightncandy.php');

class LCRunTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers LCRun::ifvar
     */
    public function testOn_ifvar() {
        $method = new ReflectionMethod('LCRun', 'ifvar');
        $this->assertEquals(false, $method->invoke(null,
            'a', Array(), Array()
        ));
        $this->assertEquals(false, $method->invoke(null,
            'a', Array(), Array('a' => null)
        ));
        $this->assertEquals(false, $method->invoke(null,
            'a', Array(), Array('a' => 0)
        ));
        $this->assertEquals(false, $method->invoke(null,
            'a', Array(), Array('a' => false)
        ));
        $this->assertEquals(true, $method->invoke(null,
            'a', Array(), Array('a' => true)
        ));
        $this->assertEquals(true, $method->invoke(null,
            'a', Array(), Array('a' => 1)
        ));
        $this->assertEquals(false, $method->invoke(null,
            'a', Array(), Array('a' => '')
        ));
        $this->assertEquals(false, $method->invoke(null,
            'a', Array(), Array('a' => Array())
        ));
        $this->assertEquals(true, $method->invoke(null,
            'a', Array(), Array('a' => Array(''))
        ));
        $this->assertEquals(true, $method->invoke(null,
            'a', Array(), Array('a' => Array(0))
        ));
    }
    /**
     * @covers LCRun::ifv
     */
    public function testOn_ifv() {
        $method = new ReflectionMethod('LCRun', 'ifv');
        $this->assertEquals('', $method->invoke(null,
            'a', Array('scopes' => Array()), Array(), function () {return 'Y';}
        ));
        $this->assertEquals('Y', $method->invoke(null,
            'a', Array('scopes' => Array()), Array('a' => 1), function () {return 'Y';}
        ));
        $this->assertEquals('N', $method->invoke(null,
            'a', Array('scopes' => Array()), Array(), function () {return 'Y';}, function () {return 'N';}
        ));
        $this->assertEquals('N', $method->invoke(null,
            'a', Array('scopes' => Array()), Array('a' => null), function () {return 'Y';}, function () {return 'N';}
        ));
        $this->assertEquals('N', $method->invoke(null,
            'a', Array('scopes' => Array()), Array('a' => false), function () {return 'Y';}, function () {return 'N';}
        ));
        $this->assertEquals('N', $method->invoke(null,
            'a', Array('scopes' => Array()), Array('a' => ''), function () {return 'Y';}, function () {return 'N';}
        ));
        $this->assertEquals('N', $method->invoke(null,
            'a', Array('scopes' => Array()), Array('a' => Array()), function () {return 'Y';}, function () {return 'N';}
        ));
        $this->assertEquals('N', $method->invoke(null,
            'a', Array('scopes' => Array()), Array('a' => 0), function () {return 'Y';}, function () {return 'N';}
        ));
        $this->assertEquals('Y', $method->invoke(null,
            'a', Array('scopes' => Array()), Array('a' => Array(0)), function () {return 'Y';}, function () {return 'N';}
        ));
    }
    /**
     * @covers LCRun::unl
     */
    public function testOn_unl() {
        $method = new ReflectionMethod('LCRun', 'unl');
        $this->assertEquals('Y', $method->invoke(null,
            'a', Array('scopes' => Array()), Array(), function () {return 'Y';}
        ));
        $this->assertEquals('', $method->invoke(null,
            'a', Array('scopes' => Array()), Array('a' => 1), function () {return 'Y';}
        ));
        $this->assertEquals('Y', $method->invoke(null,
            'a', Array('scopes' => Array()), Array(), function () {return 'Y';}, function () {return 'N';}
        ));
        $this->assertEquals('Y', $method->invoke(null,
            'a', Array('scopes' => Array()), Array('a' => null), function () {return 'Y';}, function () {return 'N';}
        ));
        $this->assertEquals('Y', $method->invoke(null,
            'a', Array('scopes' => Array()), Array('a' => false), function () {return 'Y';}, function () {return 'N';}
        ));
        $this->assertEquals('Y', $method->invoke(null,
            'a', Array('scopes' => Array()), Array('a' => ''), function () {return 'Y';}, function () {return 'N';}
        ));
        $this->assertEquals('Y', $method->invoke(null,
            'a', Array('scopes' => Array()), Array('a' => Array()), function () {return 'Y';}, function () {return 'N';}
        ));
        $this->assertEquals('Y', $method->invoke(null,
            'a', Array('scopes' => Array()), Array('a' => 0), function () {return 'Y';}, function () {return 'N';}
        ));
        $this->assertEquals('N', $method->invoke(null,
            'a', Array('scopes' => Array()), Array('a' => Array(0)), function () {return 'Y';}, function () {return 'N';}
        ));
    }
    /**
     * @covers LCRun::isec
     */
    public function testOn_isec() {
        $method = new ReflectionMethod('LCRun', 'isec');
        $this->assertEquals(true, $method->invoke(null,
            'a', Array(), Array()
        ));
        $this->assertEquals(false, $method->invoke(null,
            'a', Array(), Array('a' => 0)
        ));
        $this->assertEquals(true, $method->invoke(null,
            'a', Array(), Array('a' => false)
        ));
        $this->assertEquals(false, $method->invoke(null,
            'a', Array(), Array('a' => 'false')
        ));
        $this->assertEquals(true, $method->invoke(null,
            'a', Array(), Array('a' => null)
        ));
    }
    /**
     * @covers LCRun::val
     */
    public function testOn_val() {
        $method = new ReflectionMethod('LCRun', 'val');
        $this->assertEquals(Array(), $method->invoke(null,
            Array(null), Array(), Array()
        ));
        $this->assertEquals(Array('a'), $method->invoke(null,
            Array(null), Array(), Array('a')
        ));
        $this->assertEquals(null, $method->invoke(null,
            Array('a'), Array(), Array()
        ));
        $this->assertEquals('a', $method->invoke(null,
            Array('"a"'), Array(), Array()
        ));
        $this->assertEquals('a', $method->invoke(null,
            Array('@index'), Array('sp_vars' => Array('index' => 'a')), Array()
        ));
        $this->assertEquals('b', $method->invoke(null,
            Array('@key'), Array('sp_vars' => Array('key' => 'b')), Array()
        ));
        $this->assertEquals(0, $method->invoke(null,
            Array('a'), Array(), Array('a' => 0)
        ));
        $this->assertEquals(false, $method->invoke(null,
            Array('a'), Array(), Array('a' => false)
        ));
        $this->assertEquals(null, $method->invoke(null,
            Array('a','b'), Array(), Array('a' => 0)
        ));
        $this->assertEquals(null, $method->invoke(null,
            Array('a','b'), Array(), Array()
        ));
        $this->assertEquals('Q', $method->invoke(null,
            Array('a','b'), Array(), Array('a' => Array('b' => 'Q'))
        ));
        $this->assertEquals('', $method->invoke(null,
            Array(1), Array('scopes' => Array()), Array()
        ));
        $this->assertEquals('Y', $method->invoke(null,
            Array(1), Array('scopes' => Array('Y')), Array()
        ));
        $this->assertEquals(null, $method->invoke(null,
            Array(1, 'a'), Array('scopes' => Array('Y')), Array()
        ));
        $this->assertEquals('q', $method->invoke(null,
            Array(1, 'a'), Array('scopes' => Array(Array('a' => 'q'))), Array()
        ));
        $this->assertEquals('o', $method->invoke(null,
            Array(2, 'a'), Array('scopes' => Array(Array('a' => 'o'), Array('a' => 'p'))), Array()
        ));
        $this->assertEquals('x', $method->invoke(null,
            Array(3), Array('scopes' => Array('x', Array('a' => 'q'), Array('b' => 'r'))), Array()
        ));
        $this->assertEquals('o', $method->invoke(null,
            Array(3, 'c'), Array('scopes' => Array(Array('c' => 'o'), Array('a' => 'q'), Array('b' => 'r'))), Array()
        ));
    }
    /**
     * @covers LCRun::raw
     */
    public function testOn_raw() {
        $method = new ReflectionMethod('LCRun', 'raw');
        $this->assertEquals(true, $method->invoke(null,
            '', Array('flags' => Array('jstrue' => 0)), true
        ));
        $this->assertEquals('true', $method->invoke(null,
            '', Array('flags' => Array('jstrue' => 1)), true
        ));
        $this->assertEquals('', $method->invoke(null,
            '', Array('flags' => Array('jstrue' => 0)), false
        ));
        $this->assertEquals('', $method->invoke(null,
            '', Array('flags' => Array('jstrue' => 1)), false
        ));
        $this->assertEquals('false', $method->invoke(null,
            '', Array('flags' => Array('jstrue' => 1)), false, true
        ));
        $this->assertEquals(Array('a', 'b'), $method->invoke(null,
            '', Array('flags' => Array('jstrue' => 1, 'jsobj' => 0)), Array('a', 'b')
        ));
        $this->assertEquals('a,b', $method->invoke(null,
            '', Array('flags' => Array('jstrue' => 1, 'jsobj' => 1)), Array('a', 'b')
        ));
        $this->assertEquals('[object Object]', $method->invoke(null,
            '', Array('flags' => Array('jstrue' => 1, 'jsobj' => 1)), Array('a', 'c' => 'b')
        ));
        $this->assertEquals('[object Object]', $method->invoke(null,
            '', Array('flags' => Array('jstrue' => 1, 'jsobj' => 1)), Array('c' => 'b')
        ));
        $this->assertEquals('a,true', $method->invoke(null,
            '', Array('flags' => Array('jstrue' => 1, 'jsobj' => 1)), Array('a', true)
        ));
        $this->assertEquals('a,1', $method->invoke(null,
            '', Array('flags' => Array('jstrue' => 0, 'jsobj' => 1)), Array('a', true)
        ));
        $this->assertEquals('a,', $method->invoke(null,
            '', Array('flags' => Array('jstrue' => 0, 'jsobj' => 1)), Array('a', false)
        ));
        $this->assertEquals('a,false', $method->invoke(null,
            '', Array('flags' => Array('jstrue' => 1, 'jsobj' => 1)), Array('a', false)
        ));
    }
    /**
     * @covers LCRun::enc
     */
    public function testOn_enc() {
        $method = new ReflectionMethod('LCRun', 'enc');
        $this->assertEquals('a', $method->invoke(null,
            '', Array(), 'a'
        ));
        $this->assertEquals('a&amp;b', $method->invoke(null,
            '', Array(), 'a&b'
        ));
        $this->assertEquals('a&#039;b', $method->invoke(null,
            '', Array(), 'a\'b'
        ));
    }
    /**
     * @covers LCRun::encq
     */
    public function testOn_encq() {
        $method = new ReflectionMethod('LCRun', 'encq');
        $this->assertEquals('a', $method->invoke(null,
            '', Array(), 'a'
        ));
        $this->assertEquals('a&amp;b', $method->invoke(null,
            '', Array(), 'a&b'
        ));
        $this->assertEquals('a&#x27;b', $method->invoke(null,
            '', Array(), 'a\'b'
        ));
    }
    /**
     * @covers LCRun::sec
     */
    public function testOn_sec() {
        $method = new ReflectionMethod('LCRun', 'sec');
        $this->assertEquals('', $method->invoke(null,
            '', Array(), false, false, function () {return 'A';}
        ));
        $this->assertEquals('', $method->invoke(null,
            '', Array(), null, false, function () {return 'A';}
        ));
        $this->assertEquals('A', $method->invoke(null,
            '', Array(), true, false, function () {return 'A';}
        ));
        $this->assertEquals('A', $method->invoke(null,
            '', Array(), 0, false, function () {return 'A';}
        ));
        $this->assertEquals('-a=', $method->invoke(null,
            '', Array(), Array('a'), false, function ($c, $i) {return "-$i=";}
        ));
        $this->assertEquals('-a=-b=', $method->invoke(null,
            '', Array(), Array('a', 'b'), false, function ($c, $i) {return "-$i=";}
        ));
        $this->assertEquals('', $method->invoke(null,
            '', Array(), 'abc', true, function ($c, $i) {return "-$i=";}
        ));
        $this->assertEquals('-b=', $method->invoke(null,
            '', Array(), Array('a' => 'b'), true, function ($c, $i) {return "-$i=";}
        ));
        $this->assertEquals('', $method->invoke(null,
            'b', Array(), Array('a' => 'b'), true, function ($c, $i) {return "-{$i['a']}=";}
        ));
        $this->assertEquals(0, $method->invoke(null,
            'a', Array(), Array('a' => 'b'), false, function ($c, $i) {return count($i);}
        ));
        $this->assertEquals('1', $method->invoke(null,
            'a', Array(), Array('a' => 1), false, function ($c, $i) {return print_r($i, true);}
        ));
        $this->assertEquals('0', $method->invoke(null,
            'a', Array(), Array('a' => 0), false, function ($c, $i) {return print_r($i, true);}
        ));
        $this->assertEquals('{"b":"c"}', $method->invoke(null,
            'a', Array(), Array('a' => Array('b' => 'c')), false, function ($c, $i) {return json_encode($i);}
        ));
    }
    /**
     * @covers LCRun::wi
     */
    public function testOn_wi() {
        $method = new ReflectionMethod('LCRun', 'wi');
        $this->assertEquals('', $method->invoke(null,
            '', Array(), false, function () {return 'A';}
        ));
        $this->assertEquals('', $method->invoke(null,
            '', Array(), null, function () {return 'A';}
        ));
        $this->assertEquals('-Array=', $method->invoke(null,
            '', Array(), Array('a' => 'b'), function ($c, $i) {return "-$i=";}
        ));
        $this->assertEquals('-b=', $method->invoke(null,
            'a', Array(), Array('a' => 'b'), function ($c, $i) {return "-$i=";}
        ));
    }
    /**
     * @covers LCRun::ch
     */
    public function testOn_ch() {
        $method = new ReflectionMethod('LCRun', 'ch');
        $this->assertEquals('=-=', $method->invoke(null,
            'a', Array(''), 'raw', Array('helpers' => Array('a' => function ($i) {return "=$i=";})), '-'
        ));
        $this->assertEquals('=&amp;=', $method->invoke(null,
            'a', Array(''), 'enc', Array('helpers' => Array('a' => function ($i) {return "=$i=";})), '&'
        ));
        $this->assertEquals('=&#x27;=', $method->invoke(null,
            'a', Array(''), 'encq', Array('helpers' => Array('a' => function ($i) {return "=$i=";})), '\''
        ));
    }
}
?>