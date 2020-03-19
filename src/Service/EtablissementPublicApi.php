<?php

namespace App\Service;

class EtablissementPublicApi {

    public function getInstitution($communes_codes, $institution_type) {

        $institutions = [];

        foreach ($communes_codes as $code) {

            $uri = "https://etablissements-publics.api.gouv.fr/v3/communes/" . $code . "/" . $institution_type;

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

            if (curl_errno($curl)) {
                $error_msg = curl_error($curl);
                return false;
            }


            // exécution de la session
            $response = json_decode(curl_exec($curl), true);

            // fermeture des ressources
            curl_close($curl);

            array_push($institutions, $response);
        }

        return $institutions;
    }
}