<?php

namespace Striide\InventoryBundle\Service;

class MediaService
{
  public function __construct($provider,$context, $media_manager)
  {
    $this->provider = $provider;
    $this->context = $context;
    $this->media_manager = $media_manager;
  }

  private $provider = null;
  public function setProvider($provider)
  {
    $this->provider = $provider;
  }

  private $context = null;
  public function setContext($context)
  {
    $this->context = $context;
  }

  private $media_manager = null;
  public function setMediaManager($manager)
  {
    $this->media_manager = $manager;
  }
  private function getMediaManager()
  {
    return $this->media_manager;
  }

  /**
   * save media
   * @param string $binaryContent path to binary content
   * @param string $context
   */
  function save($binaryContent)
  {
    $media = $this->getMediaManager()->create();
    $media->setBinaryContent($binaryContent);

    $media->setEnabled(true);

    $this->getMediaManager()->save($media, $this->context, $this->provider);

    return $media;
  }
}
