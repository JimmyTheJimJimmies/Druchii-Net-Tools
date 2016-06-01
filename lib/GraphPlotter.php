<?php

class GraphPlotter {
	
	private $builder;
	
	private $scores;
	private $cumulative_scores;
	private $reduction_scores;
	
	private $messages;	
	
	private $padding = 10;
	private $pos_x = 0;
	private $pos_y = 0;
	private $bar_width=25;
	private $bar_space=2;
	private $bar_height=100;
	private $sum_bar_height=20;
	private $text_height = 16;
	private $icon_size = 18;
	
	private $avg = -1;
	private $variance = 0;
		
	private $summary = array(
		"max_valid"=>0,
		"max_summary"=>0,
		"good"=>0,
		"poor"=>0,
		"max_bar_count" =>0,
		"good_bar_count" =>0,
		"poor_bar_count" =>0
	);	
	
	
	
	
	public function __construct() {
		$this->scores = array();
		$this->messages = array();
	}
	
	public function setBuilder($builder){
		$this->builder = $builder;
	}
	
	public function setResults($results, $threshold = 0.008) {
	
		ksort($results);
		$rest = 1;
		$addition = 0;
		
		$this->summary['max_summary']=0;
		$this->summary['max_valid']=0;
		$this->summary['good']=0;
		$this->summary['poor']=0;
		$this->avg = 0;
		
		if(count($results) == 0) {
			$this->messages[] = array('error', "No valid results");
			return false;
		}
		
		for($i=0; $i<= max(array_keys($results)); $i++) {
			$score = isset($results[$i]) ? $results[$i] : 0;
			$addition += $score;
			if($score >= $threshold) {
			
				$this->scores[$i] = $score;
				$this->cumulative_scores[$i] = $addition;
				$this->reduction_scores[$i] = $rest;
				
				
			}
		
			if($rest > 5/6) {
				$this->summary['good'] = $i;
				$this->summary['good_bar_count'] = count($this->scores) -1;
			}
			if($rest > 1/6) {
				$this->summary['poor'] = $i;
				$this->summary['poor_bar_count'] = count($this->scores);
			}
			if($rest > max(0.01, $threshold)) {
				$this->summary['max_summary'] = $i;
				$this->summary['max_bar_count'] = count($this->scores);
			
			}
			if($rest > max(0.002, $threshold)) $this->summary['max_valid'] = $i;
			$rest -= $score;
			$this->avg += $score * $i;
		}
		forEach($results as $score => $chance) {
			$this->variance += $chance * pow($score - $this->avg, 2);
		}
	
	
		$this->summary['min']=0;
		$this->summary['max']=max(array_keys($this->scores), 0);
		
		if(count($this->scores) == 0) {
			$this->messages[] = array('warning', "Every outcome has a very low probability.");
			$this->summary['good_bar_count'] = 1;
			$this->summary['poor_bar_count'] = 3;
			$this->summary['max_bar_count'] = 4;
			
		}
		//print_r($this->summary); print_r($this->scores);
	}
	
	public function setAverage($avg) {
		$this->avg = $avg;
	}
	
	private function nextPlot(){
		$this->pos_y += $this->padding;
		$this->pos_x = $this->padding;
	}
	
	public function barLength($blocks){
			return ($this->bar_width + $this->bar_space) * $blocks;
	}
	
	public function plotSummaryBar($from, $to, $style) {
		if($to > $from) {
			$this->builder->addBar($this->pos_x + $this->barLength($from), $this->pos_y, $this->barLength($to-$from), $this->sum_bar_height, $style);
		}
	}
	public function plotSummaryText($score, $bar_count, $style) {
		$this->builder->addText($this->pos_x + $this->barLength($bar_count) + (($score>9)?4:7), $this->pos_y + $this->text_height - 2, $score, $style);
	}	
	public function plotSummary($avg = true) {
		$this->nextPlot();
		
		$this->plotSummaryBar(0, $this->summary['good_bar_count'], 'good');
		$this->plotSummaryBar($this->summary['good_bar_count'], min($this->summary['poor_bar_count'], $this->summary['max_bar_count']), 'expected');
		$this->plotSummaryBar(min($this->summary['poor_bar_count'], $this->summary['max_bar_count']), $this->summary['max_bar_count'], 'poor');
		
		$this->plotSummaryText($this->summary['good'], min($this->summary['good_bar_count'], $this->summary['max_bar_count']), 'bar_summary');
		$this->plotSummaryText($this->summary['poor'], $this->summary['poor_bar_count']-1, 'bar_summary');
		if($this->summary['max_bar_count'] >  $this->summary['poor_bar_count']) {
			$this->plotSummaryText($this->summary['max_summary'], $this->summary['max_bar_count']-1, 'bar_summary');
		}
		if(($this->avg > 0) && $avg) {
			$this->builder->addBar($this->pos_x + $this->barLength($this->avg+0.5), $this->pos_y, 2, $this->sum_bar_height*2, 'average');
			$this->builder->addText($this->pos_x + $this->barLength($this->summary['max_summary']+1) + 5, $this->pos_y + $this->text_height, 
				round($this->avg, 2) . ' avg, ' . round($this->scores[0]*100, 2) . '% to get 0' ,
				'average');
			$this->pos_y += 2 + $this->text_height;
		}
		$this->pos_y += $this->sum_bar_height;
	}
	public function plotScores() {
		$this->plotBreakdown($this->scores);
	}
	public function plotCummulativeScores() {
		$this->plotBreakdown($this->cumulative_scores, '-');
	}
	public function plotReductionScores() {
		$this->plotBreakdown($this->reduction_scores, '+');
	}
	private function plotBreakdown($scores, $suffix = '') {
		if(count($scores) == 0) {
			return false;
		}
		$this->nextPlot();
		$highscore = max($scores);
		$barcount = 0;
		forEach($scores as $score=>$chance){
			$this->builder->addBar($this->pos_x + $this->barLength($barcount), $this->pos_y+$this->text_height+($highscore-$chance)*$this->bar_height, 
				$this->bar_width, $this->bar_height * $chance, 'score');
			$this->builder->addText($this->pos_x + $this->barLength($barcount)+(($chance>=0.1)?1:6), $this->pos_y+$this->text_height+($highscore-$chance)*$this->bar_height -2, round($chance*100).'%', 'score');
			$this->builder->addText($this->pos_x+ $this->barLength($barcount) - strlen($suffix) * 3 +(($score>9)?5:9), $this->pos_y+$this->text_height*2+$highscore*$this->bar_height, $score . $suffix, 'score'); 
			$barcount++;
			if($score>=$this->summary['max_valid']) break;
						
		}
		
		$this->pos_y += $this->bar_height * $highscore + 2 * $this->text_height;
	
	}
	
	public function plotMessage($icon, $type, $message) {
		$this->nextPlot();
		$this->builder->addIcon($this->pos_x, $this->pos_y, $this->icon_size, $icon); 
		$this->builder->addText($this->pos_x + $this->icon_size + 5, $this->pos_y + $this->text_height, $message , $type); 
	}
	
	public function plotMessages() {
		forEach($this->messages as $message) {
			$this->plotMessage($message[0], $message[0], $message[1]);
		}
	}

	
	public function plotVariance() {
		$std = sqrt($this->variance);
		$this->nextPlot();
		$this->builder->addText($this->pos_x, $this->pos_y + $this->text_height, "Average &#956;: " . round($this->avg,2) , "info"); 
		$this->builder->addText($this->pos_x, $this->pos_y + $this->text_height*2, "Variance: " . round($this->variance,2) , "info"); 
		$this->builder->addText($this->pos_x, $this->pos_y + $this->text_height*3, "Std Deviation &#963;: " . round($std,2) , "info");
		
		$this->builder->addText($this->pos_x+150, $this->pos_y + $this->text_height, "3&#963;: " . max(0,round($this->avg - 3*$std,2)) . " - " . round($this->avg + 3*$std,2), "info"); 
		$this->builder->addText($this->pos_x+150, $this->pos_y + $this->text_height*2, "2&#963;: " . max(0,round($this->avg - 2*$std,2)) . " - " . round($this->avg + 2*$std,2), "info"); 
		$this->builder->addText($this->pos_x+150, $this->pos_y + $this->text_height*3, "1&#963;: " . max(0,round($this->avg - 1*$std,2)) . " - " . round($this->avg + 1*$std,2), "info"); 
	}

}

?>