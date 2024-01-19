# Chat GPT Conversation Package

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