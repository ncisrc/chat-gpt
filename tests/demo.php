<?php
require_once(__DIR__.'/../vendor/autoload.php');

$token = file_get_contents(__DIR__.'/token.key');
$chatGPT = new \Nci\OpenAi\ChatGpt($token);

$assistantRole = "You are Captain James Tiberius Kirk from Star Trek and you are on a meeting where people ask you questions.";
$chatGPT->setAssistantRole($assistantRole);

$userQuestion = "Hello Captain, I'm John Findlay, what's the name of your ship ?";
echo "--------".PHP_EOL;
echo "User question: $userQuestion".PHP_EOL;

$reply = $chatGPT->ask($userQuestion);
echo "--------".PHP_EOL;
echo "AI Reply : $reply".PHP_EOL;


$userQuestion = "I gave you my first name on the last question ? Can you repeat it please ?";
echo "--------".PHP_EOL;
echo "User question: $userQuestion".PHP_EOL;

$reply = $chatGPT->ask($userQuestion);
echo "--------".PHP_EOL;
echo "AI Reply : $reply".PHP_EOL;