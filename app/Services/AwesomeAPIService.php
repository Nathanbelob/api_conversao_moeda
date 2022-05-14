<?php
namespace App\Services;

use App\BO\Abs\IntegracaoServiceAbstract;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

use App\Http\Requests;
use Cache;

class AwesomeAPIService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function buscaMoedas()
    {
        try{
            $response = $this->client->request('GET', 'https://economia.awesomeapi.com.br/json/all');
    
            return json_decode($response->getBody());
        } catch (\Exception $e)
        {
            return $e;
        } catch (GuzzleException $ge)
        {
            return $ge;
        }
    }
}
