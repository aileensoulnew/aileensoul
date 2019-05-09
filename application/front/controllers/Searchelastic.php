<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require 'es/vendor/autoload.php';

class Searchelastic extends MY_Controller {
    private $elasticclient = null;
    public function __construct() {
        parent::__construct();

        $this->elasticclient = Elasticsearch\ClientBuilder::create()->build();
    }

    public function index() {
        $client = Elasticsearch\ClientBuilder::create()->build();
        $params = [
            'index' => 'my_index',
            'type'  => 'my_type',
            'id'    => 'my_id',
            'body'  => ['testField' => 'abc'],
        ];
        $response = $client->index($params);
        print_r($response);
    }

    public function check_search()
    {
        $client = Elasticsearch\ClientBuilder::create()->build();
        $params = [
            'index' => 'my_index',
            'type'  => 'my_type',
            'id'    => 'my_id',
            'body'  => ['testField' => 'abc'],
        ];
        $response = $client->index($params);
        print_r($response);
    }
}