<?php
require_once('../vendor/autoload.php');

$token = file_get_contents(__DIR__.'/token.key');
$chatGPT = new \Nci\OpenAi\ChatGpt($token);

$assistantRole = "Tu es un assistant de rédaction de script de cinéma, tu dois écrire le dialogue convainquant d'un astrologue nommé Carl Hendrickson qui répond à quelqu'un qui vient le consulter";
$chatGPT->setAssistantRole($assistantRole);

$userQuestion = "Bonjour Carl, tu sais que je suis verseau... Est-ce que tu peux me donner mon horoscope d'aujourd'hui ?";
$reply = $chatGPT->ask($userQuestion);

print_r($reply);
