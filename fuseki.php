<?php

class Fuseki {

    private $server;
    private $dataset;
    private $BASE_URL;
    private $sparql;

    public function __construct($server, $dataset) {
		$this->server = $server;
		$this->dataset = $dataset;
		$this->BASE_URL = "{$this->server}/{$this->dataset}";
    }

    private function getData($query) {
        if (!function_exists('curl_init')) {
            die('CURL is not installed!');
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "{$this->BASE_URL}/query");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'query=' . urlencode($this->sparql) . '&format=json');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return $response;
    }

    public function setDataset($dst) {
		$this->dataset = $dst;
    }

    public function setFusekiServer($fuseki) {
		$this->server = $fuseki;
    }

    public function setSparql($str) {
		$this->sparql = $str;
    }

    public function sendRequest() {
        $response = json_decode($this->getData($this->sparql), true);

        return $response['results']['bindings'];
    }
}