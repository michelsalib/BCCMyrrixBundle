<?php

namespace BCC\MyrrixBundle;

use BCC\Myrrix\MyrrixClient;

class MyrrixService
{
    /**
     * @var MyrrixClient
     */
    protected $client;

    function __construct($host, $port)
    {
        $this->client = MyrrixClient::factory(array(
            'hostname' => $host,
            'port'     => $port,
        ));
    }

    public function getRecommendation($userId, $count = null)
    {
        $command = $this->client->getCommand('GetRecommendation', array(
            'userId'  => $userId,
            'howMany'  => $count,
        ));

        return $this->client->execute($command)->json();
    }

    public function getRecommendationToMany(array $userIds, $count = null)
    {
        $command = $this->client->getCommand('GetRecommendationToMany', array(
            'userIds'  => $userIds,
            'howMany'  => $count,
        ));

        return $this->client->execute($command)->json();
    }

    public function setPreference($userId, $itemId, $value = null)
    {
        $command = $this->client->getCommand('PostPref', array(
            'userID' => $userId,
            'itemID' => $itemId,
            'value'  => $value !== null ? (string)$value : null,
        ));

        return $this->client->execute($command)->isSuccessful();
    }

    public function setPreferences(array $preferences)
    {
        $command = $this->client->getCommand('Ingest', array(
            'data' => $preferences,
        ));

        return $this->client->execute($command)->isSuccessful();
    }

    public function removePreference($userId, $itemId)
    {
        $command = $this->client->getCommand('RemovePref', array(
            'userID' => $userId,
            'itemID' => $itemId,
        ));

        return $this->client->execute($command)->isSuccessful();
    }

    public function getBecause($userId, $itemId)
    {
        $command = $this->client->getCommand('GetBecause', array(
            'userId'  => $userId,
            'itemID'  => $itemId,
        ));

        return $this->client->execute($command)->json();
    }

    public function getEstimations($userId, array $itemIds)
    {
        $command = $this->client->getCommand('GetEstimation', array(
            'userId'  => $userId,
            'itemIDs' => $itemIds,
        ));

        $result = $this->client->execute($command)->getBody(true);

        return preg_split('/\r\n/', trim($result));
    }

    public function getSimilarItems(array $itemIds, $count = null)
    {
        $command = $this->client->getCommand('GetSimilarity', array(
            'itemIDs' => $itemIds,
            'howMany' => $count,
        ));

        return $this->client->execute($command)->json();
    }

    public function getUsers()
    {
        $command = $this->client->getCommand('GetAllUserIDs');

        return $this->client->execute($command)->json();
    }

    public function getItems()
    {
        $command = $this->client->getCommand('GetAllItemIDs');

        return $this->client->execute($command)->json();
    }

    public function refresh()
    {
        $command = $this->client->getCommand('Refresh');

        return $this->client->execute($command)->isSuccessful();
    }

    public function isReady()
    {
        $command = $this->client->getCommand('Ready');

        return $this->client->execute($command)->isSuccessful();
    }

    /**
     * @return MyrrixClient
     */
    public function getClient()
    {
        return $this->client;
    }
}
