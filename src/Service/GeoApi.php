<?php

namespace App\Service;

class GeoApi {

    public function getCommunes($data) {

        $postal_code = $data['postal_code'];
        $commune = $data['commune'];
        $uri = 'https://geo.api.gouv.fr/communes?';

        if ($postal_code && $commune) {
          $uri = $uri . "codePostal=" . $postal_code . "&nom=" . $commune . "&fields=&format=json&geometry=centre";
        } else if ($postal_code) {
           $uri = $uri . "codePostal=" . $postal_code . "&fields=&format=json&geometry=centre";
        } else if ($commune) {
           $uri = $uri . "nom=" . $commune . "&fields=&format=json&geometry=centre";
        }

        // initialisation de la session
        $curl = curl_init();

        $options = [
            CURLOPT_URL  => $uri,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FAILONERROR => true
        ];

        curl_setopt_array($curl, $options);

        // exécution de la session
        $response = json_decode(curl_exec($curl), true);

        $commune_code = [];

        foreach($response as $commune_item) {
          array_push($commune_code, $commune_item['code']);
        }

        // fermeture des ressources
        curl_close($curl);

        return $commune_code;
    }
}