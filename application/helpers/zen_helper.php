<?php

function btnEdit($uri) {
	$str = '<i class="fa text-success fa-edit"></i>';
	return anchor($uri,$str, array('onclick'=> "showModal()"));
}


function btnDelete($uri) {
	$str = '<i class="fa text-danger fa-trash"></i>';
	return anchor($uri, $str, array('onclick'=> "return confirm('Apakah anda yakin?');"));
}

function toRP($nom) {
	return number_format($nom,'0',',','.');
}

function hitungDisc($disc1,$disc2,$het) {
	$disc1 = $het - $het * $disc1 / 100;
	$disc2 = $disc1 - $disc1 * $disc2 /100;
	return $disc2;
}

function toIndo($str) {
	$data = explode ('-',$str);
    return (string) $data[2].'-'.$data[1].'-'.$data[0];
}


function toRome($str) {
	$data=null;
	switch ($str) {
		case 1:
			$data = 'I';
			break;
		case 2:
			$data = 'II';
			break;
		case 3:
			$data = 'III';
			break;
		case 4:
			$data = 'IV';
			break;
		case 5:
			$data = 'V';
			break;
		case 6:
			$data = 'VI';
			break;
		case 7:
			$data = 'VII';
			break;
		case 8:
			$data = 'VIII';
			break;
		case 9:
			$data = 'IX';
			break;
		case 10:
			$data = 'X';
			break;
		case 11:
			$data = 'XI';
			break;
		default:
			$data = 'XII';
			break;
	}

	return $data;
}
