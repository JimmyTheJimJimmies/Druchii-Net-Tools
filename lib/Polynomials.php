<?php
/**
 * Library for algebraic operations on polynomials
 *
 * PHP version 5
 *
 * LICENSE: 
 *
 * @package    Library
 * @author     Daeron <Dieter.De.Verschrikkelijke@gmail.com>
 * @copyright  2012 Druchii.Net
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    GIT: $Id$
 * @since      File available since Release 0.0.1
 */

 /**
  * Multiplies two polynomials
  *
  * Polynomials are implemented as array, with the index of the coefficient marking the 
  * order of x. Missing orders are denoted with 0.
  * For example:
  *    (5 + 2x) * (7 + 3x^2)
  * Becomes:
  *    multiply_polynomials([5,2], [7,0,3]);
  * Returns:  
  *    [35,14,15,6]
  * Which stands for:
  *  (35 + 14x + 15x^2 + 5x^3)
  * 
  * @param $first array
  * @param $second array
  * @return array
  */
 

function multiply_polynomials($x1, $x2) {
	$result = array();
	forEach($x1 as $i => $ai){
		if($ai != 0) {
			forEach($x2 as $j => $bj) {
				if($bj !=0) {
					if(isset($result[$i+$j])) {
						$result[($i+$j)] = $ai * $bj + $result[($i+$j)];
					} else {
						$result[($i+$j)] = $ai * $bj;
					}
				}
			}
		}
	}
	return $result;
}
/**
 * Raises polynomial to the given power
 *
 * For example:
 *   (5 + 2x)^2
 * Becomes:
 *   polynomial_to_power([5,2],2)
 * Returns:
 *   [25,20,4]
 * Which stands for:
 * (25 + 20x + 4x^2)
 *  
 * @param $x array
 * @param $n integer
 * @return array
 */
 
function polynomial_to_power($x, $n) {
	if($n == 0) return array(1);
	$result = $x;
	for($i = 2; $i <= $n; $i++) {
		$result = multiply_polynomials($result, $x);
	}
	return $result;
}

/**
 * Raises polynomial to the given power
 *
 * Should be roughly twice as fast.
 * 
 * @param $x array
 * @param $n integer
 * @return array
 */
function polynomial_to_power_quick($x, $number) {
	$result = null;
	$part = $x;
	do{
		if($number%2 == 1) {
			$result = is_null($result) ? $part : multiply_polynomials($result, $part);
			$number--;
		}
		$number = $number / 2;
	} while(
		($number >=1) 
		&& ($part = multiply_polynomials($part, $part)));
	return $result;	
}

/**
 * Polynomial substitution 
 * Given: 
 *  X = SUM a_i * X^i 
 *  Y = SUM b_j * Y^j
 * Computes:
 *  R = SUM a_i * (Y)^i
 * For example:
 * (5 + 2x), (4 + 3y) 
 *	= 5 + 2 * (4 + 3y)
 *  = 5 + 8 + 6y
 *  = 13 + 6y
 * Defines this to help:
 *  Zi = (Y)^i
 *     = SUM c_k * Z^k
 * Polynomials are implemented as array, with
 * the position of the coefficient marking the 
 * order of x. 
 * (5 + 2x) -> [0=> 5, 1=>2]
 * Result ->  [0=>13, 1=>6]
 * 
 * Uses FOREACH loop, assuming this is the quickest
 * according to http://www.phpbench.com/
 * 
 * @param $x array
 * @param $y array
 * @return array
 */
 
 
function substitute_polynomial($x, $y) {
	$result = array();
	$zi = array(1);
	$last_power = 0;
	ksort($x);
	forEach($x as $i => $ai){
		if($ai != 0) {
			$zi = multiply_polynomials($zi, polynomial_to_power($y, ($i - $last_power)));
			$last_power = $i;
			forEach($zi as $k => $ck) {
				$result[$k] = $ai * $ck + (isset($result[$k])? $result[$k] : 0);		
			}
		}
	}
	return $result;
}




?>