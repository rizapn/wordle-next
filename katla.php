<?php

//======================================================//
//  Script  : katla.php 								//
//	Author 	: Feb 9, 2022 								//
// 	Update 	: Feb 11, 2022								//
//------------------------------------------------------//
//  Script to help solving wordle puzzle 				//
//======================================================//

$MAX = 20;
$lang = 'id';

$p = $argv[1];
if (strlen($p)==0) {
	print PHP_EOL."Usage : php ".$argv[0]." \"par1=value1&par2=value2...\"".PHP_EOL.
		"par = g|guess|no|ok|max|lang".PHP_EOL.
		"- g|guess = guesses split by comma".PHP_EOL.
		"   - / 0 : invalid char".PHP_EOL.
		"   . / 1 : wrong position".PHP_EOL.
		"   + / 2 : good position".PHP_EOL.
		"- max  = maximum word displayed (default=20)".PHP_EOL.
		"- lang = id|en (default=id, Indonesian)".PHP_EOL;
	exit;
}

parse_str($p,$PARS);

if ($M = $PARS['max']) $MAX = $M;
if ($M = $PARS['lang']) $lang = $M;

$temp = @file_get_contents("kata-${lang}.json");
$K5 = json_decode($temp,true);
if (empty($K5)) {
	print "Unsupported language [$lang]\r\n";
	exit;
}
$LEN = strlen($K5[0]);
for ($j=1; $j<=$LEN; $j++) $POS[$j] = '0';

if ($M = $PARS['g']) $PARS['guess'] = $M;
if ($M = $PARS['guess']) {
	$W = explode(',',$M);
	foreach ($W as $w) {
		$NUM = array();
		for ($i=0; $i<$LEN; $i++) {
			$f = substr($w,$LEN+$i,1);
			$c = substr($w,$i,1);
			$j = $i+1;
			if ($f==' ' || $f=='+' || $f=='2') {
				$POS[$j] = $c;
				$ID[$c][$j] = 2;						// good-position
				$NUM[$c]++;
			}
			else if ($f=='.' || $f=='1') {
				$NUM[$c]++;
				$ID[$c][$j] = 1;						// wrong-position
			}
			else if ($f=='-' || $f=='0') {
				$ID[$c][$j] = 3;						// not-allowed
				//$ID[$c][0] = 1;							// not-allowed-all
			}
		}
		foreach ($NUM as $c=>$n) if ($ID[$c][0]<$n) $ID[$c][0] = $n;
	}
}

$NUM = array();
$find = 0;
foreach ($ID as $c=>$ar) {
	$n = $ID[$c][0];
	if ($n>0) {
		$find++;
		$NUM[$c] = $n;
	}
}

arsort($POS);

if ($PARS['debug']==1) {
	print_r($ID);
	print_r($POS);
	print_r($NUM);
	print "[find=$find]".PHP_EOL;
	exit;
}

$num = 0;
foreach ($K5 as $kata) {
	$f = 0;
	$NX = $NUM;
	foreach ($POS as $j=>$p) {
	//for ($i=0; $i<$LEN; $i++) {
		$i = $j-1;
		$c = substr($kata,$i,1);
		$idc = $ID[$c];
		//$p = $POS[$j];
		if ($p>='a') {									// pos taken
			if ($p==$c) { $NX[$c]--; $f++; }			// good char
			else $f = -1;
		}
		else if (!isset($idc)) continue;				// allowed chars
		else if ($NUM[$c]<1 || 							// char is not allowed at all
			$idc[$j]>0) $f = -1;						// char is not allowed here
		else if ($NX[$c]-->0) $f++;
		if ($f<0) break;
	}
	if ($f>=$find) {
		print "[$kata]";
		$num++;
		if ($num%10==0) print PHP_EOL;
		if ($num>$MAX) {
			print PHP_EOL."Too many matches.";
			break;
		}
	}
}
print PHP_EOL;

?>
