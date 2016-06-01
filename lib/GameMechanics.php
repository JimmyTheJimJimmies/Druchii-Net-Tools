<?php

/**
 * dice_outcomes
 * 	Given a number of dice, it calculates the odds for every outcome.
 *
 * @param n the number of dice
 */

function dice_outcomes($number, $sides, $fixed, $limit = 0)
{
	if(($number < 1) && ($limit == 0)) {
		return array($fixed=>1);
	}
	if($number < 1) {
		return array(min($fixed, $limit)=>1);
	}
	$single_dice =  array_fill(1,$sides, 1/$sides);
	$dice_rolls = polynomial_to_power($single_dice, $number);
	$result = array();
	forEach($dice_rolls as $roll => $chance) {
		$score = ($limit != 0)? min($roll+$fixed, $limit) : $roll+$fixed;
		$result[$score] = isset($result[$score]) ? $result[$score] + $chance : $chance;
	}
	return $result;
}

function artillery_outcomes($number, $fixed, $limit = 0)
{
	$artillery  = array(1/6,0,1/6,0,1/6,0,1/6,0,1/6,0,1/6);
	$dice_rolls = polynomial_to_power($artillery, $number);
	$result = array();
	forEach($dice_rolls as $roll => $chance) {
		$result[($roll+$fixed)] = $chance;
	}
	return $result;
}

/**
 * 
 */
function make_wound_chart($chance_wound, $chance_kb, $multiple, $max_wounds)
{
	$chance_fail = 1 - $chance_wound - $chance_kb;
	$chart = array(0=>$chance_fail, $max_wounds=>$chance_kb);
	forEach($multiple as $wounds => $chance) {
		$score = min($wounds, $max_wounds);
		if(isset($chart[$score])) { 
			$chart[$score] += $chance * $chance_wound;
		} else {
			$chart[$score] = $chance * $chance_wound;
		}
	}
	return $chart;
}

function roll_chance($rerollfail, $rollsuccess, $rerollsuccess, $limit = 7) {
	return ($rerollsuccess - $rollsuccess) / 6 + ($limit-$rerollsuccess+$rerollfail) * (7-$rollsuccess)/36;
}

function roll_interval($rollfrom, $rollto) {
	if($rollfrom >= $rollto) return 0;
	else return ($rollto-$rollfrom) / 6;
}

function roll_to_chance($roll) {
	if($roll == 0) return 0;
	if($roll > 6) {
		return 1/6 * roll_to_chance($roll -3);
	}
	return (7-$roll) / 6;
}





?>