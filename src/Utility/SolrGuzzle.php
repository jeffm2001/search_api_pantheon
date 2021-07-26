<?php

namespace Drupal\search_api_pantheon\Utility;

use Http\Factory\Guzzle\RequestFactory;
use Http\Factory\Guzzle\StreamFactory;
use RicardoFiorani\GuzzlePsr18Adapter\Client;
use Solarium\Core\Client\Adapter\AdapterInterface;
use Solarium\Core\Client\Adapter\Psr18Adapter;

/**
 * Class SolrGuzzle
 * Convenience class to produce a PSR18Adapter configured correctly for our Solr server.
 *
 *
 * @package Drupal\search_api_pantheon\Utility
 */
class SolrGuzzle {

  /**
   * @return \Psr\Http\Client\ClientInterface
   */
  public static function getConfiguredClientInterface(): Client
  {
    $cert = $_SERVER['HOME'] . '/certs/binding.pem';
    $guzzleConfig = [
      'base_uri' => Cores::getBaseUri(),
      'http_errors' => false,
      'debug' => false,
      'verify' => false,
    ];
    if (is_file($cert)) {
      $guzzleConfig['cert'] = $cert;
    }
    return new \RicardoFiorani\GuzzlePsr18Adapter\Client(
      $guzzleConfig
    );
  }


  /**
   * @return \Solarium\Core\Client\Adapter\AdapterInterface
   */
  public static function getPsr18Adapter(): AdapterInterface
  {
    return new Psr18Adapter(
      static::getConfiguredClientInterface(),
      new RequestFactory(),
      new StreamFactory()
    );
  }


}
