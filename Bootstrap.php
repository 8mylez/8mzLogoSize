<?php

use Doctrine\Common\Collections\ArrayCollection;

class Shopware_Plugins_Frontend_8mzLogoSize_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{

  public function getLabel()
  {
    return 'Logo Größe anpassen';
  }

  public function getVersion()
  {
    return '1.0.0';
  }

  public function getInfo()
  {
    return array(
      'version' => $this->getVersion(),
      'copyright' => 'Copyright (c) 2016, Goltfisch GmbH',
      'label' => $this->getLabel(),
      'description' => 'Ermöglicht die Anpassung des Logos im Backend',
      'support' => 'http://8mylez.com',
      'link' => 'http://8mylez.com',
      'author' => '8mylez'
    );
  }

  public function install()
  {

    $this->subscribeEvent(
      'Theme_Compiler_Collect_Plugin_Less',
      'onCollectLessFiles'
    );

    $this->createConfig();

    return true;
  }

  private function createConfig()
  {

    $form = $this->Form();

    $form->setElement(
      'number',
      'logoHeight',
      [
        'scope' => Shopware\Models\Config\Element::SCOPE_SHOP,
        'label' => 'Logo Höhe',
        'minValue' => 0,
        'description' => 'Höhe des Logos in Pixel.'
      ]
    );

    $form->setElement(
      'number',
      'logoHeightCheckout',
      [
        'scope' => Shopware\Models\Config\Element::SCOPE_SHOP,
        'label' => 'Logo Checkout Höhe',
        'minValue' => '0',
        'description' => 'Höhe des Logos in Pixel im Checkout Prozess.'
      ]
    );

  }

  public function onCollectLessFiles()
  {
    $lessDir = __DIR__ . '/Views/frontend/_public/src/less/';

    $less = new \Shopware\Components\Theme\LessDefinition(
      array(
        'logoHeight' => $this->Config()->get('logoHeight'),
        'logoHeightCheckout' => $this->Config()->get('logoHeightCheckout'),
      ),
      array(
        $lessDir . 'logo-size.less'
      )
    );

    return new ArrayCollection(array($less));
  }
}
