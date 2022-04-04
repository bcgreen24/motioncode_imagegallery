<?php

namespace Drupal\getimages\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\getimages\Services\GetimagesService;

/**
 * Controller for the movie quote.
 */

class GetimagesController extends ControllerBase
{
    /**
     * @var \Drupal\getimages\GetimagesService
     */

    protected $images;

    /**
     * GetimagesController constructor.
     * 
     * @param \Drupal\getimages\GetimagesService $images
     */

    public function __construct(GetimagesService $images)
    {
        $this->images = $images;
    }

    public static function create(ContainerInterface $container)
    {
        return new static(
            $container->get('getimages.images')
        );
    }

    function images()
    {
        $json = $this->images->getImages();

        return [
            '#theme' => 'getimages-template',
            '#images' => $json,
            '#attached' => [
                'library' => [
                    'getimages/getimages-library'
                ]
            ],
            '#cache' => [
                'max-age', 600
            ]
        ];
    }
}
