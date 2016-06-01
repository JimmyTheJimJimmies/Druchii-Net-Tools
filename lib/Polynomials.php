<?php



/***
 * The extensive library of functions
 *
 ***/
 
/**
 * Polynomial multiplication. 
 * Given: 
 *  X1 = SUM a_i * X^i 
 *  X2 = SUM b_j * X^j
 * Computes:
 *  X1 * X2 = SUM c_k * X^k
 * Where for any k:
 *  c_k = SUM a_i * b_j (where i+j = k)
 * For example:
 * (5 + 2x) * (7 + 3x^2) = 35 + 14x + 15x^2 + 6x^3
 * 
 * Polynomials are implemented as array, with
 * the position of the coefficient marking the 
 * order of x. Missing orders are denoted with 0.
 * (5 + 2x) -> [0=> 5, 1=>2]
 * (7 + 3x^2) -> [0=>7, 2=>3]
 * Result ->  [0=>35,1=>14,2=>15,3=>6]
 * Uses FOREACH loop, assuming this is the quickest
 * according to http://www.phpbench.com/
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
				$result[($i+$j)] = $ai * $bj + (isset($result[($i+$j)])? $result[($i+$j)] : 0);		
			}
		}
	}
	return $result;
}
/**
 * Polynomial exponentiation (if that's even a word) 
 * Given: 
 *  X = SUM a_i * X^i 
 *  n element of N
 * Computes:
 *  X ^ n = X * ... * X (n times)
 * For example:
 * (5 + 2x)^2 = 25 + 20x + 4x^2
 * 
 * Polynomials are implemented as array, with
 * the position of the coefficient marking the 
 * order of x. 
 * (5 + 2x) -> [0=> 5, 1=>2]
 * (5 + 2x)^2 ->  [0=>25, 1=>20, 2=>4]
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
 * polynomial_to_power_quick
 * Same as the above, except quicker.
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