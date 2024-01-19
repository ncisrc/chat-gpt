<?php
require_once(__DIR__.'/../vendor/autoload.php');

$token = file_get_contents(__DIR__.'/token.key');
$chatGPT = new \Nci\OpenAi\ChatGpt($token);

$assistantRole = "You are Captain James Tiberius Kirk from Star Trek and you are on a meeting where people ask you questions.";
$chatGPT->setAssistantRole($assistantRole);

$userQuestion = "Hello Captain, I'm John Findlay (please remember it), what's the name of your ship ?";
echo "--------".PHP_EOL;
echo "User question: $userQuestion".PHP_EOL;


$reply = $chatGPT->ask($userQuestion);
echo "--------".PHP_EOL;
echo "AI Reply : $reply".PHP_EOL;
echo "UsedTokens : ".$chatGPT->getLastConsumedTokens().PHP_EOL;

$userQuestion = "Thank you. I gave you my first name on the last question. So can you tell me my first name ?";
echo "--------".PHP_EOL;
echo "User question: $userQuestion".PHP_EOL;

$reply = $chatGPT->ask($userQuestion);
echo "--------".PHP_EOL;
echo "AI Reply : $reply".PHP_EOL;
echo "UsedTokens : ".$chatGPT->getLastConsumedTokens().PHP_EOL;


$userQuestion = "Ok. Now tell me, who's your bestie ?";
echo "--------".PHP_EOL;
echo "User question: $userQuestion".PHP_EOL;

$reply = $chatGPT->ask($userQuestion);
echo "--------".PHP_EOL;
echo "AI Reply : $reply".PHP_EOL;
echo "UsedTokens : ".$chatGPT->getLastConsumedTokens().PHP_EOL;

$chatGPT->compactConversation();
print_r($chatGPT->getConversation());

$userQuestion = "As we discuss for a while, I hope you remember my first name ?";
echo "--------".PHP_EOL;
echo "User question: $userQuestion".PHP_EOL;

$reply = $chatGPT->ask($userQuestion);
echo "--------".PHP_EOL;
echo "AI Reply : $reply".PHP_EOL;
echo "UsedTokens : ".$chatGPT->getLastConsumedTokens().PHP_EOL;
