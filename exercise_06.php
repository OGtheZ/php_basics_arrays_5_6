<?php

$wordList = ["jazz", "acronym", "python", "quadrillion", "insanity", "survivalist"];
$wordToGuess = $wordList[rand(0, count($wordList)-1)];
$splitWord = str_split($wordToGuess, 1);
$splitWordMasked = [];
foreach($splitWord as $letter) {
    array_push($splitWordMasked, "-");
}
$wordForDisplay = implode(" ", $splitWordMasked);

$gameIsLive = true;

$triesLeft = 10;

$guess = "";

$display = function () use (&$wordForDisplay, &$triesLeft, &$guess) {
    echo "-=-=-=-=-=-=-=-=-=-=-=-=-=" . PHP_EOL;
    echo "Word: ";
    echo $wordForDisplay . PHP_EOL;
    echo "Guesses: " . $guess . PHP_EOL;
    echo "Tries left: $triesLeft" . PHP_EOL;
    };

$display();

while($gameIsLive) {
    $input = readline("Enter a letter: ");
    if (strlen($input) > 1) {
        echo "You must only enter one letter!" . PHP_EOL;
        continue;
    } elseif (is_numeric($input)) {
        echo "You must only use letters!" . PHP_EOL;
        continue;
    }
    if (!in_array($input, $splitWord)) {
        if (in_array($input, explode(" ", $guess))) {
            echo "You tried this one!" . PHP_EOL;
            continue;
        }
        $guess .= "{$input} ";
        $triesLeft--;
    } else {
        $positions = array_keys($splitWord, $input);
        if (count($positions) < 2) {
            $newDisplayWord = explode(" ", $wordForDisplay);
            array_splice($newDisplayWord, (int) implode(" ",$positions), 1, $input);
            $wordForDisplay = implode(" ", $newDisplayWord);
        } else {
            foreach ($positions as $position) {
                $newDisplayWord = explode(" ", $wordForDisplay);
                array_splice($newDisplayWord, $position, 1, $input);
                $wordForDisplay = implode(" ", $newDisplayWord);
            }
        }
        if (str_replace(" ","",$wordForDisplay) === $wordToGuess) {
            echo "You win!" . PHP_EOL;
            echo "The word was {$wordToGuess}!" . PHP_EOL;
            $gameIsLive = false;
            exit;
        }
    }

    $display();

    if ($triesLeft < 1) {
        $gameIsLive = false;
        echo "No more tries! The word was $wordToGuess!" . PHP_EOL;
    }
}
