<?php
function get_alphabet($word) {
	$j='A';
	for($i=0;$i<26;$i++) {
		$alphabet[$j] = "<s>".$j."</s>";	//erst alle falsch machen z.b. mit durchgestrichenen buchstaben
		$j++;
	}
	for($i=0;$i<strlen($word);$i++) {
		$alphabet[$word[$i]] = $word[$i];
	}
	return $alphabet;
}

function print_word($word,$letters) {
	for($i=0;$i<strlen($letters);$i++) {
		$my_alphabet[$letters[$i]] = $letters[$i];
	}
	$j=0;
	for($i=0;$i<strlen($word);$i++) {
		if($my_alphabet[$word[$i]] != '') {
			echo $my_alphabet[$word[$i]]." ";
		} else {
			echo "_ ";
			$j++;
		}
	}
	if($j == 0) {
		return 1;
	} else {
		return 0;
	}
}

function get_wrong_letters($letters,$alphabet,$design) {
	if($design == 1) {
		echo "<br>";
	}
	$wrong_letters = 0;
	for($i=0;$i<strlen($letters);$i++) {
		echo $alphabet[$letters[$i]]." ";
		if($alphabet[$letters[$i]] != $letters[$i]) {
			$wrong_letters++;
		}
	}
	if($design == 1) {
		echo "<br>".strlen($letters)." guessed, ".$wrong_letters." wrong letter(s)";
	} else {
		echo "(".strlen($letters).", ".$wrong_letters." wrong)";
	}
	return $wrong_letters;
}

function sort_players($word,$players,$ids,$words,$letters,$wrong_letters) {
	$right_numb = 0;	//number of right guessers
	$wrong_numb = 0;	//number of wrong guessers
	$best_one['id'] = 0;
	$best_one['tries'] = 100;
	$best_one['bad_tries'] = 10;
	$best_one['same_stats'] = 0;
	for($i=1;$i<$players;$i++) {
		if($words[$i] == $word && $wrong_letters[$i] <9) {
			$right_ones[$right_numb] = $i;
			if($best_one['tries'] > strlen($letters[$i]) ||
			($best_one['tries'] == strlen($letters[$i]) && $best_one['bad_tries'] > $wrong_letters[$i]) ) { //beides geringer
				$best_one['id'] = $ids[$i];
				$best_one['tries'] = strlen($letters[$i]);
				$best_one['bad_tries'] = $wrong_letters[$i];
				$best_one['list_number'] = $i;
				$best_one['same_stats'] = 1;
			} else if($best_one['tries'] == strlen($letters[$i]) && $best_one['bad_tries'] == $wrong_letters[$i]) { //beide gleich
				$best_one['id'] = $best_one['id'].";".$ids[$i];
				$best_one['same_stats']++;
			}
			$right_numb++;
		} else {
			$wrong_ones[$wrong_numb] = $i;
			$wrong_numb++;
		}
	}
	$result['intr'] = $right_numb;
	$result['intwin'] = $best_one['same_stats'];
	$result['intw'] = $wrong_numb;
	$result['listr'] = $right_ones;
	$result['listw'] = $wrong_ones;
	$result['winner_list'] = $best_one['list_number'];
	$result['winner_id'] = $best_one['id'];
	return $result;
}

?>