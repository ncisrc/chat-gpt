# Chat GPT Conversation Package

## Feature :
* Ability to choose the IA engine :
  * gpt-4-1106-preview
  * gpt-4
  * gpt-4-32k
  * gpt-3.5-turbo-1106
  * gpt-3.5-turbo
  * gpt-3.5-turbo-16k
  * gpt-3.5-turbo-instruct

* Ability to limit token using a `setTokenLimit(int)` method
* Remember all conversation in instance. Conversation can be hydrated using the `setConversation(array)` method. (conversation array should follow the chat GPT conversation pattern to work)
* Ability to compact conversation to bypass the maximum token limit using `compactConversation()` method (see demo).

## Example :
```php
// example.php
require_once('vendor/autoload.php');

$token = file_get_contents(__DIR__.'/token.key');
$chatGPT = new \Nci\OpenAi\ChatGpt($token);

$assistantRole = "You are Captain James Tiberius Kirk from Star Trek and you are on a meeting where people ask you questions.";
$chatGPT->setAssistantRole($assistantRole);

$userQuestion = "Hello Captain, I'm john, what's the name of your ship ?";
$reply = $chatGPT->ask($userQuestion);
echo $reply.PHP_EOL;

$userQuestion = "I gave you my first name on the last question ? Can you repeat it please ?";
$reply = $chatGPT->ask($userQuestion);
echo $reply.PHP_EOL;
```