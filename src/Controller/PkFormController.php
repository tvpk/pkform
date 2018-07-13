<?php

namespace Drupal\pkform\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\pkform\Form\PkForm;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * An example controller.
 */
class PkFormController extends ControllerBase {

  protected $formBuilder;

  public function __construct(FormBuilderInterface $form_builder) {
    $this->formBuilder = $form_builder;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('form_builder')
    );
  }

  /**
   * Returns a render-able array for a test page.
   */
  public function content() {

    $page = [
      '#prefix' => '<div id="pkform">',
      '#suffix' => '</div>',
    ];

    $page = array(
      '#prefix' => '<div id="pkform">',
      '#suffix' => '</div>'
    );

    // Without dependency injection. Leaving this as an example.
    // $page['form'] = \Drupal::formBuilder()->getForm('Drupal\pkform\Form\PkForm');

    // Using dependency injection.
    $page['form'] = $this->formBuilder()->getForm('Drupal\pkform\Form\PkForm');

    return $page;
  }

}