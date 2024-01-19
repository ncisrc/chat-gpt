<?php
namespace NCI\OpenAi;

use NCI\OpenAi\ChatGptException;

class ChatGpt
{
  private static string $apiUrl = "https://api.openai.com/v1/chat/completions";
  private static array $availableEngineModels = [
    'gpt-4-1106-preview',
    'gpt-4',
    'gpt-4-32k',
    'gpt-3.5-turbo-1106',
    'gpt-3.5-turbo',
    'gpt-3.5-turbo-16k',
    'gpt-3.5-turbo-instruct'
  ];

  protected string $apiKey;
  protected string $userQuery = "";
  protected string $assistantRole = "Vous êtes un assistant";
  protected string $apiEngineModel = "gpt-3.5-turbo-1106";
  protected array | null  $lastResponse = null;
  protected int | null $tokenLimit = null;

  protected array $conversation = [];

  function __construct($apiKey)
  {
    $this->apiKey = $apiKey;
  }

  public static function getApiEngines() : array
  {
    return self::$availableEngineModels;
  }

  public function setApiEngine(int $apiEngine) : void
  {
    if (!in_array($apiEngine, self::$availableEngineModels)) {
      throw new ChatGptException("Invalid model: {$apiEngine}, available models are : ".implode(', ', self::$availableEngineModels));
    }
    $this->apiEngineModel = $apiEngine;
  }

  public function ask($question) : string
  {
    $this->setQuestion($question);
    $this->execute();
    return $this->getLastReply();
  }

  public function setAssistantRole($roleDescription) : void
  {
    if (trim($roleDescription) == "") {
      throw new ChatGptException("Role description cannot be empty");
    }
    $this->assistantRole = $roleDescription;
  }

  public function setQuestion($question) : void
  {
    if (trim($question) == "") {
      throw new ChatGptException("User question cannot be empty");
    }
    $this->userQuery = $question;
  }

  public function setTokenLimit(int | null $tokenLimit = null) : void
  {
    $this->tokenLimit = $tokenLimit;
  }

  public function getFullConversation() : array {
    return $this->conversation;
  }

  public function getLastQuestion() : string | null {
    if (count($this->conversation) < 2) return null;
    $lastIndex = count($this->conversation) - 2;
    return $this->conversation[$lastIndex]['content'];
  }

  public function getLastReply() : string | null {
    if (count($this->conversation) < 1) return null;
    $lastIndex = count($this->conversation) - 1;
    return $this->conversation[$lastIndex]['content'];
  }

  public function getLastResponse() : array | null {
    return $this->lastResponse;
  }

  public function execute() : bool
  {
    if (trim($this->userQuery) == "") {
      throw new ChatGptException("User query cannot be empty");
    }

    $this->conversation[] = ['role' => 'user', 'content' => $this->userQuery];
    $this->userQuery = "";

    $response = $this->restPost();

    if (!$response) {
      throw new ChatGptException("An error occurred while calling the API.");
    }

    $this->lastResponse = json_decode($response, true);

    if (array_key_exists('error', $this->lastResponse)) {
      throw new ChatGptException($this->lastResponse['error']['message'].' : '.$this->lastResponse['error']['type']);
    }

    $this->conversation[] = $this->lastResponse['choices'][0]['message'];

    return true;
  }

  private function queryData() : array {
    $queryData = [
      'model' => $this->apiEngineModel,
      'messages' => array_merge([['role' => 'assistant', 'content' => $this->assistantRole]], $this->conversation),
    ];

    if ($this->tokenLimit) {
      $queryData['max_tokens'] = $this->tokenLimit;
    }

    return $queryData;
  }

  private function restPost() : string {
    $headers = [
      'Content-Type: application/json',
      'Authorization: Bearer ' . $this->apiKey
    ];

    $data = $this->queryData();

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, self::$apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
  }
}