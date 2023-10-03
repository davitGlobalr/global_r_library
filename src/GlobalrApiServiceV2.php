<?php

use GuzzleHttp\Client;

class GlobalrApiServiceV2
{

    private $userEmail;
    private $userPassword;
    private $apiToken;
    private $accessTkoen;
    private $refreshToken;
    private Client $client;

    public function __construct()
    {
        $this->userEmail = ''; // User login email.
        $this->userPassword = ''; // User login password.
        $this->apiToken = ''; // To get an API token, please contact the GlobalR support team.
        $this->client = new Client();
        $this->login();
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function sendRequest(string $method, string $url, array $data = [])
    {
        $options['headers'] = ['Content-Type' => 'application/json', 'Authorization' => 'Bearer ' . $this->accessTkoen];
        $options['json'] = $data;
        $uri = 'https://globalr.com/api/v2' . $url;
        return $this->client->request($method, $uri, $options);
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function login()
    {
        try {
            $requestData = [
                'email' => $this->userEmail,
                'password' => $this->userPassword,
                'api_token' => $this->apiToken,
            ];

            $response = $this->sendRequest('POST', '/login', $requestData)->getBody()->getContents();
            $tokens = json_decode($response, true);
            $this->accessTkoen = $tokens['access_token'];
            $this->refreshToken = $tokens['refresh_token'];

        } catch (\Exception $exception) {
            throw new \Exception('Faild to login.');
        }
    }

    /**
     * @return mixed|string[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateTokens()
    {
        try {
            $response = $this->sendRequest('POST', '/tokens/update', ['refresh_token' => $this->refreshToken])->getBody()->getContents();
            return json_decode($response, true);
        } catch (\Exception $exception) {
            return ['error' => 'Unable to update tokens.'];
        }
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function logout()
    {
        try {
            $response = $this->sendRequest('POST', '/logout')->getBody()->getContents();
            return json_decode($response, true);
        } catch (\Exception $exception) {
            throw new \Exception('Faild to logout.');
        }
    }

    /**
     * @return mixed|string[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function resellerInfo()
    {
        try {
            $response = $this->sendRequest('GET', '/reseller_info')->getBody()->getContents();
            return json_decode($response, true);
        } catch (\Exception $exception) {
            return ['error' => 'User not found.'];
        }
    }

    /**
     * @param string $domain
     * @return mixed|string[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getDomainInfomation(string $domain)
    {
        try {
            $response = $this->sendRequest('GET', "/domain/$domain")->getBody()->getContents();
            return json_decode($response, true);
        } catch (\Exception $exception) {
            return ['error' => 'Domain not found.'];
        }
    }

    /**
     * @param array $domainData
     * @return mixed|string[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function registerDomain(array $domainData)
    {
        try {
            $response = $this->sendRequest('POST', "/domain", $domainData)->getBody()->getContents();
            return json_decode($response, true);
        } catch (\Exception $exception) {
            return ['error' => 'Unable to register domain.'];
        }
    }

    /**
     * @param array $renewData
     * @return mixed|string[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function renewDomain(array $renewData)
    {
        try {
            $response = $this->sendRequest('POST', "/domain/renew", $renewData)->getBody()->getContents();
            return json_decode($response, true);
        } catch (\Exception $exception) {
            return ['error' => 'Unable to renew domain.'];
        }
    }

    /**
     * @param array $autoRenewParams
     * @return mixed|string[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function autoRenewDomain(array $autoRenewParams)
    {
        try {
            $response = $this->sendRequest('POST', "/domain/autoRenew", $autoRenewParams)->getBody()->getContents();
            return json_decode($response, true);
        } catch (\Exception $exception) {
            return ['error' => 'Unable to activate autorenew for domain.'];
        }
    }

    /**
     * @param array $domainData
     * @return mixed|string[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function modifyDomain(array $domainData)
    {
        try {
            $response = $this->sendRequest('PUT', "/domain", $domainData)->getBody()->getContents();
            return json_decode($response, true);
        } catch (\Exception $exception) {
            return ['error' => 'Unable to modify domain.'];
        }
    }

    /**
     * @param array $bulkData
     * @return mixed|string[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function dnsBulkUpdate(array $bulkData)
    {
        try {
            $response = $this->sendRequest('POST', "/domain/nameservers/bulkupdate", $bulkData)->getBody()->getContents();
            return json_decode($response, true);
        } catch (\Exception $exception) {
            return ['error' => 'Unable to bulk update.'];
        }
    }

}
