<?php

class Momo
{
    private $apiKey = "";

    function __construct()
    {
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function collect()
    {
        $collectionRequest = new Private_Chipdeals_MomoApi_Class_CollectionRequest($this->apiKey, Private_Chipdeals_MomoApi_Class_CollectionUtils::class);
        $collectionRequest->firstName("Anonymous")->lastName("Anonymous");
        return $collectionRequest;
    }

    public function deposit()
    {
        return new Private_Chipdeals_MomoApi_Class_DepositRequest($this->apiKey, Private_Chipdeals_MomoApi_Class_DepositUtils::class);
    }

    public function getStatus($reference)
    {
        return Private_Chipdeals_MomoApi_Class_TransactionController::getStatus($reference, $this->apiKey, Private_Chipdeals_MomoApi_Class_TransactionUtils::class);
    }

    public function getBalances()
    {
        return Private_Chipdeals_MomoApi_Class_BalanceController::getBalances($this->apiKey, Private_Chipdeals_MomoApi_Class_BalanceUtils::class);
    }

    public function parseWebhookData($requestBody)
    {
        return Private_Chipdeals_MomoApi_Class_TransactionUtils::parseWebhookData($requestBody);
    }
}





/**
 * Balance/UseCases/GetBalance.php
 */
class Private_Chipdeals_MomoApi_Class_GetBalances
{
    public static function exec(Private_Chipdeals_MomoApi_Class_BalanceData $balance, $Private_Chipdeals_MomoApi_Class_BalanceUtils)
    {
        return  $Private_Chipdeals_MomoApi_Class_BalanceUtils::getBalances($balance);
    }
}


/**
 * Balance/BalanceController.php
 */
class Private_Chipdeals_MomoApi_Class_BalanceController
{

    public static function getBalances($apiKey, $balanceUtils)
    {
        $balanceSample = new Private_Chipdeals_MomoApi_Class_BalanceData();
        $balanceSample->setApiKey($apiKey);
        $balances = Private_Chipdeals_MomoApi_Class_GetBalances::exec($balanceSample, $balanceUtils);
        $balancesResponse = [];
        foreach ($balances as $key => $balance) {
            $balancesResponse[$key] = new Private_Chipdeals_MomoApi_Class_BalanceResponse($balance);
        }
        return $balancesResponse;
    }
}


/**
 * Balance/BalanceData.php
 */
class Private_Chipdeals_MomoApi_Class_BalanceData
{
    private $countryCode = "";
    private $operator = "";
    private $currency = "";
    private $amount = "";
    private $apiKey = "";

    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    public function getCountryCode()
    {
        return $this->countryCode;
    }

    public function setOperator($operator)
    {
        $this->operator = $operator;
        return $this;
    }

    public function getOperator()
    {
        return $this->operator;
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }


    public function getArray()
    {
        return [
            "countryCode" => $this->countryCode,
            "operator" => $this->operator,
            "currency" => $this->currency,
            "amount" => $this->amount,
            "apiKey" => $this->apiKey,
        ];
    }
};


/**
 * Balance/BalanceResponse.php
 */
class Private_Chipdeals_MomoApi_Class_BalanceResponse
{
    private $balance;

    function __construct(Private_Chipdeals_MomoApi_Class_BalanceData $balance)
    {
        $this->balance = $balance;
    }

    public function getCountryCode()
    {
        return $this->balance->getCountryCode();
    }

    public function getOperator()
    {
        return $this->balance->getOperator();
    }

    public function getCurrency()
    {
        return $this->balance->getCurrency();
    }

    public function getAmount()
    {
        return $this->balance->getAmount();
    }

    public function getArray()
    {
        return [
            "countryCode" => $this->balance->getCountryCode(),
            "operator" => $this->balance->getOperator(),
            "currency" => $this->balance->getCurrency(),
            "amount" => $this->balance->getAmount(),
        ];
    }
};


/**
 * Collection/UseCases/Collect.php
 */
class Private_Chipdeals_MomoApi_Class_Collect
{
    public static function exec(Private_Chipdeals_MomoApi_Class_TransactionData $collection, $Private_Chipdeals_MomoApi_Class_CollectionUtils)
    {
        $Private_Chipdeals_MomoApi_Class_CollectionUtils::sendCollectionRequest($collection);
    }
}


/**
 * Collection/CollectionController.php
 */
class CollectionController
{

    public static function collect(Private_Chipdeals_MomoApi_Class_TransactionData $collection, $Private_Chipdeals_MomoApi_Class_collectionUtils)
    {
        Private_Chipdeals_MomoApi_Class_Collect::exec($collection, $Private_Chipdeals_MomoApi_Class_collectionUtils);
    }
}


/**
 * Collection/CollectionExecution.php
 */
class Private_Chipdeals_MomoApi_Class_CollectionExecution
{

    private $collection;
    private $Private_Chipdeals_MomoApi_Class_collectionUtils;

    function __construct(Private_Chipdeals_MomoApi_Class_TransactionData $collection, $Private_Chipdeals_MomoApi_Class_collectionUtils)
    {
        $this->collection = $collection;
        $this->Private_Chipdeals_MomoApi_Class_collectionUtils = $Private_Chipdeals_MomoApi_Class_collectionUtils;
    }

    public function start()
    {
        CollectionController::collect($this->collection, $this->Private_Chipdeals_MomoApi_Class_collectionUtils);
        return $this->onCollectionResponse();
    }

    private function onCollectionResponse()
    {
        $collectionResponse = new Private_Chipdeals_MomoApi_Class_TransactionResponse($this->collection);
        return $collectionResponse;
    }
};


/**
 * Collection/CollectionRequest.php
 */
class Private_Chipdeals_MomoApi_Class_CollectionRequest
{

    private $collection;
    private $Private_Chipdeals_MomoApi_Class_collectionUtils;

    function __construct($apiKey, $Private_Chipdeals_MomoApi_Class_collectionUtils)
    {
        $this->collection = new Private_Chipdeals_MomoApi_Class_TransactionData();
        $this->collection->setApiKey($apiKey);
        $this->collection->setIsCollection(true);
        $this->Private_Chipdeals_MomoApi_Class_collectionUtils = $Private_Chipdeals_MomoApi_Class_collectionUtils;
    }


    public function amount($amount)
    {
        $this->collection->setOriginalAmount($amount);
        return $this;
    }
    public function currency($currency)
    {
        $this->collection->setOriginalCurrency($currency);
        return $this;
    }
    public function from($phoneNumber)
    {
        $this->collection->setPhoneNumber($phoneNumber);
        return $this;
    }
    public function firstName($firstName)
    {
        $this->collection->setFirstName($firstName);
        return $this;
    }
    public function lastName($lastName)
    {
        $this->collection->setLastName($lastName);
        return $this;
    }
    public function webhook($webhook)
    {
        $this->collection->setWebhookUrl($webhook);
        return $this;
    }
    public function create()
    {
        $collectionExecution = new Private_Chipdeals_MomoApi_Class_CollectionExecution($this->collection,  $this->Private_Chipdeals_MomoApi_Class_collectionUtils);
        return $collectionExecution->start();
    }
};


/**
 * Deposit/UseCases/SendDeposit.php
 */
class Private_Chipdeals_MomoApi_Class_SendDeposit
{
    public static function exec(Private_Chipdeals_MomoApi_Class_TransactionData $deposit, $Private_Chipdeals_MomoApi_Class_DepositUtils)
    {
        $Private_Chipdeals_MomoApi_Class_DepositUtils::sendDepositRequest($deposit);
    }
}


/**
 * Deposit/DepositController.php
 */
class DepositController
{

    public static function sendDeposit(Private_Chipdeals_MomoApi_Class_TransactionData $deposit, $depositUtils)
    {
        Private_Chipdeals_MomoApi_Class_SendDeposit::exec($deposit, $depositUtils);
    }
}



/**
 * Deposit/DepositExecution.php
 */
class Private_Chipdeals_MomoApi_Class_DepositExecution
{

    private $deposit;
    private $depositUtils;

    function __construct(Private_Chipdeals_MomoApi_Class_TransactionData $deposit, $depositUtils)
    {
        $this->deposit = $deposit;
        $this->depositUtils = $depositUtils;
    }

    public function start()
    {
        DepositController::sendDeposit($this->deposit, $this->depositUtils);
        return $this->onDepositResponse();
    }

    private function onDepositResponse()
    {
        $depositResponse = new Private_Chipdeals_MomoApi_Class_TransactionResponse($this->deposit);
        return $depositResponse;
    }
};



/**
 * Deposit/DepositRequest.php
 */
class Private_Chipdeals_MomoApi_Class_DepositRequest
{

    private $deposit;
    private $depositUtils;

    function __construct($apiKey, $depositUtils)
    {
        $this->deposit = new Private_Chipdeals_MomoApi_Class_TransactionData();
        $this->deposit->setApiKey($apiKey);
        $this->deposit->setIsCollection(false);
        $this->depositUtils = $depositUtils;
    }


    public function amount($amount)
    {
        $this->deposit->setOriginalAmount($amount);
        return $this;
    }
    public function currency($currency)
    {
        $this->deposit->setOriginalCurrency($currency);
        return $this;
    }
    public function to($phoneNumber)
    {
        $this->deposit->setPhoneNumber($phoneNumber);
        return $this;
    }
    public function webhook($webhook)
    {
        $this->deposit->setWebhookUrl($webhook);
        return $this;
    }
    public function create()
    {
        $depositExecution = new Private_Chipdeals_MomoApi_Class_DepositExecution($this->deposit,  $this->depositUtils);
        return $depositExecution->start();
    }
};



/**
 * Transaction/UseCases/GetStatus
 */
class Private_Chipdeals_MomoApi_Class_GetStatus
{
    public static function exec(Private_Chipdeals_MomoApi_Class_TransactionData $transaction, $Private_Chipdeals_MomoApi_Class_TransactionUtils)
    {
        $Private_Chipdeals_MomoApi_Class_TransactionUtils::checkTransactionStatus($transaction);
        return new Private_Chipdeals_MomoApi_Class_TransactionResponse($transaction);
    }
}


/**
 * Transaction/TransactionController.php
 */
class Private_Chipdeals_MomoApi_Class_TransactionController
{

    public static function getStatus($transactionReference, $apiKey, $transactionUtils)
    {
        $transaction = new Private_Chipdeals_MomoApi_Class_TransactionData();
        $transaction->setReference($transactionReference);
        $transaction->setApiKey($apiKey);
        return Private_Chipdeals_MomoApi_Class_GetStatus::exec($transaction, $transactionUtils);
    }
}

/**
 * Transaction/TransactionData.php
 */
class Private_Chipdeals_MomoApi_Class_TransactionData
{
    private $reference = "";
    private $phoneNumber = "";
    private $countryCode = "";
    private $operator = "";
    private $firstName = "";
    private $lastName = "";
    private $originalCurrency = "";
    private $originalAmount = "";
    private $currency = "";
    private $amount = "";
    private $status = "";
    private $statusMessage = "";
    private $statusCode = "";
    private $startTimestampInSecond = "";
    private $endTimestampInSecond = "";
    private $webhookUrl = "";
    private $apiKey = "";
    private $isCollection = false;

    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this;
    }

    public function getReference()
    {
        return $this->reference;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    public function getCountryCode()
    {
        return $this->countryCode;
    }

    public function setOperator($operator)
    {
        $this->operator = $operator;
        return $this;
    }

    public function getOperator()
    {
        return $this->operator;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setOriginalCurrency($originalCurrency)
    {
        $this->originalCurrency = $originalCurrency;
        return $this;
    }

    public function getOriginalCurrency()
    {
        return $this->originalCurrency;
    }

    public function setOriginalAmount($originalAmount)
    {
        $this->originalAmount = $originalAmount;
        return $this;
    }

    public function getOriginalAmount()
    {
        return $this->originalAmount;
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatusMessage($statusMessage)
    {
        $this->statusMessage = $statusMessage;
        return $this;
    }

    public function getStatusMessage()
    {
        return $this->statusMessage;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStartTimestampInSecond($startTimestampInSecond)
    {
        $this->startTimestampInSecond = $startTimestampInSecond;
        return $this;
    }

    public function getStartTimestampInSecond()
    {
        return $this->startTimestampInSecond;
    }

    public function setEndTimestampInSecond($endTimestampInSecond)
    {
        $this->endTimestampInSecond = $endTimestampInSecond;
        return $this;
    }

    public function getEndTimestampInSecond()
    {
        return $this->endTimestampInSecond;
    }

    public function setWebhookUrl($webhookUrl)
    {
        $this->webhookUrl = $webhookUrl;
        return $this;
    }

    public function getWebhookUrl()
    {
        return $this->webhookUrl;
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function setIsCollection($isCollection)
    {
        $this->isCollection = $isCollection;
        return $this;
    }

    public function getIsCollection()
    {
        return $this->isCollection;
    }

    public function getArray()
    {
        return [
            "reference" => $this->reference,
            "phoneNumber" => $this->phoneNumber,
            "countryCode" => $this->countryCode,
            "operator" => $this->operator,
            "firstName" => $this->firstName,
            "lastName" => $this->lastName,
            "originalCurrency" => $this->originalCurrency,
            "originalAmount" => $this->originalAmount,
            "currency" => $this->currency,
            "amount" => $this->amount,
            "status" => $this->status,
            "statusMessage" => $this->statusMessage,
            "statusCode" => $this->statusCode,
            "startTimestampInSecond" => $this->startTimestampInSecond,
            "endTimestampInSecond" => $this->endTimestampInSecond,
            "webhookUrl" => $this->webhookUrl,
            "apiKey" => $this->apiKey,
            "isCollection" => $this->isCollection,
        ];
    }
};


/**
 * Transaction/TransactionResponse.php
 */
class Private_Chipdeals_MomoApi_Class_TransactionResponse
{
    private $transaction;

    function __construct(Private_Chipdeals_MomoApi_Class_TransactionData $transaction)
    {
        $this->transaction = $transaction;
    }

    public function getReference()
    {
        return $this->transaction->getReference();
    }

    public function getPhoneNumber()
    {
        return $this->transaction->getPhoneNumber();
    }

    public function getCountryCode()
    {
        return $this->transaction->getCountryCode();
    }

    public function getOperator()
    {
        return $this->transaction->getOperator();
    }

    public function getFirstName()
    {
        return $this->transaction->getFirstName();
    }

    public function getLastName()
    {
        return $this->transaction->getLastName();
    }

    public function getOriginalCurrency()
    {
        return $this->transaction->getOriginalCurrency();
    }

    public function getOriginalAmount()
    {
        return $this->transaction->getOriginalAmount();
    }

    public function getCurrency()
    {
        return $this->transaction->getCurrency();
    }

    public function getAmount()
    {
        return $this->transaction->getAmount();
    }

    public function getStatus()
    {
        return $this->transaction->getStatus();
    }

    public function getStatusMessage()
    {
        return $this->transaction->getStatusMessage();
    }

    public function getStatusCode()
    {
        return $this->transaction->getStatusCode();
    }

    public function getStartTimestampInSecond()
    {
        return $this->transaction->getStartTimestampInSecond();
    }

    public function getEndTimestampInSecond()
    {
        return $this->transaction->getEndTimestampInSecond();
    }

    public function checkIsCollection()
    {
        return $this->transaction->getIsCollection();
    }

    public function getArray()
    {
        return [
            "reference" => $this->transaction->getReference(),
            "phoneNumber" => $this->transaction->getPhoneNumber(),
            "currency" => $this->transaction->getCurrency(),
            "operator" => $this->transaction->getOperator(),
            "firstName" => $this->transaction->getFirstName(),
            "lastName" => $this->transaction->getLastName(),
            "originalCurrency" => $this->transaction->getOriginalCurrency(),
            "originalAmount" => $this->transaction->getOriginalAmount(),
            "currency" => $this->transaction->getCurrency(),
            "amount" => $this->transaction->getAmount(),
            "status" => $this->transaction->getStatus(),
            "statusMessage" => $this->transaction->getStatusMessage(),
            "statusCode" => $this->transaction->getStatusCode(),
            "startTimestampInSecond" => $this->transaction->getStartTimestampInSecond(),
            "endTimestampInSecond" => $this->transaction->getEndTimestampInSecond(),
            "isCollection" => $this->transaction->getIsCollection(),
        ];
    }
};










/**
 * Utils/BalanceUtils.php
 */
class Private_Chipdeals_MomoApi_Class_BalanceUtils
{
    static public function getBalances(Private_Chipdeals_MomoApi_Class_BalanceData $balance)
    {
        $url = "https://apis.chipdeals.me/momo/balance?apikey=";
        $url .= $balance->getApiKey();
        $response = Private_Chipdeals_MomoApi_Class_Network::sendGetRequest($url);
        $balances = Private_Chipdeals_MomoApi_Class_BalanceUtils::buildBalances($response);
        return $balances;
    }


    static private function buildBalances($response)
    {
        $balancesFound = isset($response["data"]->balances[0]);
        if (!$balancesFound) return [];

        $balances = [];
        foreach ($response["data"]->balances as $key => $balanceInfo) {
            $balance = new Private_Chipdeals_MomoApi_Class_BalanceData();
            $balance->setCountryCode($balanceInfo->countryCode);
            $balance->setCurrency($balanceInfo->currency);
            $balance->setOperator($balanceInfo->operator);
            $balance->setAmount($balanceInfo->amount);
            $balances[$key] = $balance;
        }
        return $balances;
    }
}


/**
 * Utils/CollectionUtils.php
 */
class Private_Chipdeals_MomoApi_Class_CollectionUtils
{
    static public function sendCollectionRequest(Private_Chipdeals_MomoApi_Class_TransactionData $collection)
    {
        $url = "https://apis.chipdeals.me/momo/requestPayment?apikey=";
        $url .= $collection->getApiKey();
        $requestData = [
            "senderFirstName" => $collection->getFirstName(),
            "senderLastName" => $collection->getLastName(),
            "senderPhoneNumber" => $collection->getPhoneNumber(),
            "currency" => $collection->getOriginalCurrency(),
            "amount" => $collection->getOriginalAmount(),
            "webhookUrl" => $collection->getWebhookUrl(),
        ];
        $response = Private_Chipdeals_MomoApi_Class_Network::sendPostRequest($url, $requestData);
        Private_Chipdeals_MomoApi_Class_CollectionUtils::setCollectionValues($response, $collection);
    }

    static private function setCollectionValues($response, Private_Chipdeals_MomoApi_Class_TransactionData $collection)
    {
        $collection->setStatusCode($response["statusCode"]);
        $collection->setStatus("error");
        $collection->setStatusMessage($response["message"]);
        $collectionResponseFound = isset($response["data"]->payment->status);

        if (isset($response["data"]->errorCode)) {
            $collection->setStatusCode($response["data"]->errorCode);
            $collection->setStatusMessage($response["data"]->message);
        }
        if ($collectionResponseFound) {
            $collectionResponse = $response["data"]->payment;
            $collection->setReference($collectionResponse->reference);
            $collection->setPhoneNumber($collectionResponse->senderPhoneNumber);
            $collection->setCountryCode($collectionResponse->senderCountryCode);
            $collection->setOperator($collectionResponse->senderOperator);
            $collection->setFirstName($collectionResponse->senderFirstName);
            $collection->setLastName($collectionResponse->senderLastName);
            $collection->setOriginalCurrency($collectionResponse->originalCurrency);
            $collection->setCurrency($collectionResponse->currency);
            $collection->setOriginalAmount($collectionResponse->originalAmount);
            $collection->setAmount($collectionResponse->amount);
            $collection->setStatus($collectionResponse->status);
            $collection->setStatusMessage($collectionResponse->statusMessage);
            $collection->setStatusCode($collectionResponse->statusMessageCode);
            $collection->setStartTimestampInSecond($collectionResponse->startTimestampInSecond);
            $collection->setEndTimestampInSecond($collectionResponse->endTimestampInSecond);
        }
    }
}


/**
 * Utils/Deposit
 */
class Private_Chipdeals_MomoApi_Class_DepositUtils
{
    static public function sendDepositRequest(Private_Chipdeals_MomoApi_Class_TransactionData $deposit)
    {
        $url = "https://apis.chipdeals.me/momo/deposit?apikey=";
        $url .= $deposit->getApiKey();
        $requestData = [
            "recipientPhoneNumber" => $deposit->getPhoneNumber(),
            "currency" => $deposit->getOriginalCurrency(),
            "amount" => $deposit->getOriginalAmount(),
            "webhookUrl" => $deposit->getWebhookUrl(),
        ];
        $response = Private_Chipdeals_MomoApi_Class_Network::sendPostRequest($url, $requestData);
        Private_Chipdeals_MomoApi_Class_DepositUtils::setDepositValues($response, $deposit);
    }

    static private function setDepositValues($response, Private_Chipdeals_MomoApi_Class_TransactionData $deposit)
    {
        // print_r($response);
        $deposit->setStatusCode($response["statusCode"]);
        $deposit->setStatus("error");
        $deposit->setStatusMessage($response["message"]);
        $depositResponseFound = isset($response["data"]->deposit->status);

        if (isset($response["data"]->errorCode)) {
            $deposit->setStatusCode($response["data"]->errorCode);
            $deposit->setStatusMessage($response["data"]->message);
        }
        if ($depositResponseFound) {
            $depositResponse = $response["data"]->deposit;
            $deposit->setReference($depositResponse->reference);
            $deposit->setPhoneNumber($depositResponse->recipientPhoneNumber);
            $deposit->setCountryCode($depositResponse->recipientCountryCode);
            $deposit->setOperator($depositResponse->recipientOperator);
            $deposit->setOriginalCurrency($depositResponse->originalCurrency);
            $deposit->setCurrency($depositResponse->currency);
            $deposit->setOriginalAmount($depositResponse->originalAmount);
            $deposit->setAmount($depositResponse->amount);
            $deposit->setStatus($depositResponse->status);
            $deposit->setStatusMessage($depositResponse->statusMessage);
            $deposit->setStatusCode($depositResponse->statusMessageCode);
            $deposit->setStartTimestampInSecond($depositResponse->startTimestampInSecond);
            $deposit->setEndTimestampInSecond($depositResponse->endTimestampInSecond);
        }
    }
}



/**
 * Utils/Network.php
 */
class Private_Chipdeals_MomoApi_Class_Network
{
    static public function sendPostRequest($url, $body)
    {
        return Private_Chipdeals_MomoApi_Class_Network::execRequest(function ($url, $body) {
            $bodyString = json_encode($body);
            $requestUrl = $url . "&useOnlyStatusCode200=true&body=" . urlencode($bodyString);

            $jsonResponse = file_get_contents($requestUrl);
            return $jsonResponse;
        }, $url, $body);
    }

    static public function sendGetRequest($url)
    {
        return Private_Chipdeals_MomoApi_Class_Network::execRequest(function ($url) {
            $requestUrl = $url. "&useOnlyStatusCode200=true";
            $jsonResponse = file_get_contents($requestUrl);
            return $jsonResponse;
        }, $url);
    }

    static private function execRequest($networkRequestMethod, $url, $body = "{}")
    {
        $res = $networkRequestMethod($url, $body);
        return Private_Chipdeals_MomoApi_Class_Network::parseResponse($res);
    }

    static private function parseResponse($networkResponse)
    {
        $isError = false;
        if (!$networkResponse) {
            $isError = true;
            $networkResponse = '{"success":false,"message":"an error occured","errorCode":"500-100"}';
        }

        $responseData = json_decode($networkResponse);


        $errorCode = 520;
        $response = [
            "statusCode" => $errorCode,
            "message" => "An error occured",
            "data" => $responseData
        ];

        if ($isError) return $response;

        $response["statusCode"] = "200";
        $response["data"] = $responseData;
        return $response;
    }
}



/**
 * Utils/TransactionUtils.php
 */
class Private_Chipdeals_MomoApi_Class_TransactionUtils
{
    static public function checkTransactionStatus(Private_Chipdeals_MomoApi_Class_TransactionData $transaction)
    {
        $url = "https://apis.chipdeals.me/momo/status/";
        $url .= $transaction->getReference();
        $url .= "?apikey=";
        $url .= $transaction->getApiKey();
        $response = Private_Chipdeals_MomoApi_Class_Network::sendGetRequest($url);
        Private_Chipdeals_MomoApi_Class_TransactionUtils::setTransactionValues($response, $transaction);
    }

    static private function setTransactionValues($response, Private_Chipdeals_MomoApi_Class_TransactionData $transaction)
    {
        $transaction->setStatusCode($response["statusCode"]);
        $transaction->setStatus("error");
        $transaction->setStatusMessage($response["message"]);
        $transactionResponseFound = isset($response["data"]->transaction->status);

        if (isset($response["data"]->errorCode)) {
            $transaction->setStatusCode($response["data"]->errorCode);
            $transaction->setStatusMessage($response["data"]->message);
        }
        if ($transactionResponseFound) {
            $transactionResponse = $response["data"]->transaction;
            $transaction->setReference($transactionResponse->reference);
            $transaction->setOriginalCurrency($transactionResponse->originalCurrency);
            $transaction->setCurrency($transactionResponse->currency);
            $transaction->setOriginalAmount($transactionResponse->originalAmount);
            $transaction->setAmount($transactionResponse->amount);
            $transaction->setStatus($transactionResponse->status);
            $transaction->setStatusMessage($transactionResponse->statusMessage);
            $transaction->setStatusCode($transactionResponse->statusMessageCode);
            $transaction->setStartTimestampInSecond($transactionResponse->startTimestampInSecond);
            $transaction->setEndTimestampInSecond($transactionResponse->endTimestampInSecond);
            if ($transactionResponse->transactionType === "payment") {
                $transaction->setIsCollection(true);
                $transaction->setPhoneNumber($transactionResponse->senderPhoneNumber);
                $transaction->setCountryCode($transactionResponse->senderCountryCode);
                $transaction->setOperator($transactionResponse->senderOperator);
                $transaction->setFirstName($transactionResponse->senderFirstName);
                $transaction->setLastName($transactionResponse->senderLastName);
            } else {
                $transaction->setIsCollection(false);
                $transaction->setPhoneNumber($transactionResponse->recipientPhoneNumber);
                $transaction->setCountryCode($transactionResponse->recipientCountryCode);
                $transaction->setOperator($transactionResponse->recipientOperator);
            }
        }
    }

    static public function parseWebhookData($requestBody)
    {
        $transactionInfo = json_decode($requestBody["transaction"]);

        $transaction = new Private_Chipdeals_MomoApi_Class_TransactionData();
        $transaction->setReference($transactionInfo->reference);
        $transaction->setOriginalCurrency($transactionInfo->originalCurrency);
        $transaction->setCurrency($transactionInfo->currency);
        $transaction->setOriginalAmount($transactionInfo->originalAmount);
        $transaction->setAmount($transactionInfo->amount);
        $transaction->setStatus($transactionInfo->status);
        $transaction->setStatusMessage($transactionInfo->statusMessage);
        $transaction->setStatusCode($transactionInfo->statusMessageCode);
        $transaction->setStartTimestampInSecond($transactionInfo->startTimestampInSecond);
        $transaction->setEndTimestampInSecond($transactionInfo->endTimestampInSecond);
        if ($transactionInfo->transactionType === "payment") {
            $transaction->setIsCollection(true);
            $transaction->setPhoneNumber($transactionInfo->senderPhoneNumber);
            $transaction->setCountryCode($transactionInfo->senderCountryCode);
            $transaction->setOperator($transactionInfo->senderOperator);
            $transaction->setFirstName($transactionInfo->senderFirstName);
            $transaction->setLastName($transactionInfo->senderLastName);
        } else {
            $transaction->setIsCollection(false);
            $transaction->setPhoneNumber($transactionInfo->recipientPhoneNumber);
            $transaction->setCountryCode($transactionInfo->recipientCountryCode);
            $transaction->setOperator($transactionInfo->recipientOperator);
        }

        return new Private_Chipdeals_MomoApi_Class_TransactionResponse($transaction);
    }
}
