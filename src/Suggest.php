<?php

namespace isudakoff\dadata;

use isudakoff\dadata\response\Address;
use yii\base\Component;

class Suggest extends Component
{
    const TYPE_ADDRESS = "address";

    public $token;
    public $baseUrl = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/";

    /**
     * todo: add more info
     *
     * @param string $query
     * @param int $count
     *
     * @return Address[]
     */
    public function getAddresses($query, $count = 5)
    {
        $addresses = [];
        $suggestions = $this->sendRequest(self::TYPE_ADDRESS, ['query' => $query, 'count' => $count]);

        foreach ($suggestions['suggestions'] as $suggestion) {
            $addresses[] = Address::fromDaDataSuggestion($suggestion);
        }

        return $addresses;
    }

    /**
     * todo: add more info
     *
     * @param string $type
     * @param array $params
     *
     * @return array
     */
    private function sendRequest($type, $params)
    {
        $ch = curl_init();

        $isPost = $this->isPost($type);
        $url = $this->baseUrl . $type;

        if ($isPost) {
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        } else {
            $url .= "?" . http_build_query($params);
            curl_setopt($ch, CURLOPT_URL, $url);
        }

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Token ' . $this->token,
        ]);

        $result = curl_exec($ch);

        curl_close($ch);

        return json_decode($result, true);
    }

    /**
     * todo: add more info
     *
     * @param string $type Type of suggestion
     *
     * @return bool
     */
    private function isPost($type)
    {
        switch ($type) {
            case self::TYPE_ADDRESS: {
                return true;
            }
            default: {
                return false;
            }
        }
    }
}
