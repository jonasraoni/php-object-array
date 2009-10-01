<?php
/*
 * Object Array: Provides a kind of ArrayObject but with support for references and callable properties
 * Jonas Raoni Soares da Silva <http://raoni.org>
 * https://github.com/jonasraoni/php-object-array
 */

require_once 'ObjectArray.php';

$v = ['true'=> function(){
	return true;
}];

$o = new ObjectArray($v);
assert($o->true(), 'Call function'); //ArrayObject would fail here, but succeed on $o['f']->()... Looks like another PHP-WTF

$o->true = false;
assert($v['true'] === $o['true'], 'Same value'); //ArrayObject would trigger the assert as it doesn't support references