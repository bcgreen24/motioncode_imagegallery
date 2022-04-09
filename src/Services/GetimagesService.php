<?php

namespace Drupal\getimages\Services;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use GuzzleHttp\Client;
use DomDocument;

class GetimagesService
{
  use StringTranslationTrait;

  /**
   * Returns the image URLs.
   */
  public function getImages()
  {
    $config = \Drupal::config('getimages.admin_settings');

    $remote_base = $config->get('getimages_root_url');
    $api_path = $config->get('getimages_api_path');
    $content_type = $config->get('getimages_content_type');
    $image_array = [];
    $client = new Client(); //Guzzle client
    $res = $client->get($remote_base . $api_path . $content_type);

    $json_string = $res->getBody()->getContents();
    $json = json_decode($json_string);

    foreach ($json->data as $item) {
      $dom = new DOMDocument();
      $dom->loadHTML($item->attributes->body->value);
      // foreach($dom->getElementsByTagName('p') as $p){
      //   $p->remove();
      // }
      $image_tag = $dom->getElementsByTagName('img')->item(0);

      foreach ($dom->getElementsByTagName('img') as $image_tag) {
        $src = $image_tag->getAttribute('src');
        $image_tag->setAttribute('src', $remote_base . $src);
        $image_array[$dom->saveHTML()] = $remote_base . $src;
      }
      return $image_array;
    }
  }
}
