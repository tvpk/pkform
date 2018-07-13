<?php

namespace Drupal\pkform\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\HtmlCommand;

  /**
   * A simple form displaying First and Last name fields.
   */

class PkForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'pkform';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $config = $this->config('pkform.settings');
    $message = $config->get('pkform_contact_message') ? $config->get('pkform_contact_message') : "This is the message";

    $form['intro'] = array(
      '#type' => 'markup',
      '#markup' => $message,
    );
  
    $form['first_name'] = array(
      '#type' => 'textfield',
      '#title' => $this
        ->t('First Name'),
      '#required' => true,
    );
  
    $form['last_name'] = array(
      '#type' => 'textfield',
      '#title' => $this
        ->t('Last Name'),
      '#required' => true,
    );
  
    $form['phone_number'] = array(
      '#type' => 'textfield',
      '#title' => $this
        ->t('Phone Number'),
      '#required' => true,
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => $this
        ->t('Submit'),
      '#ajax' => [
        'callback' => '::ajaxSubmit',
        'progress' => [
          'type' => 'throbber',
          'message' => t('Verifying entry...'),
        ],
      ],
    );

    return $form;
  
  }

  /**
   * {@inheritdoc}
   * 
   * This is the non AJAX behaviour.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('pkform.settings');
    $confirmation_message = $config->get('pkform_contact_confirmation_message') ? $config->get('pkform_contact_confirmation_message') : "This is the message";

    $name = $form_state->getValue('first_name') . ' ' . $form_state->getValue('last_name');
    $message = str_replace('@contact', $name, $confirmation_message);
    drupal_set_message($this->t($message));
  }

  /**
   * Ajax Submit Callback
   */
  public function ajaxSubmit(array $form, FormStateInterface $form_state) {
    $config = $this->config('pkform.settings');
    $confirmation_message = $config->get('pkform_contact_confirmation_message');
    $confirmation_message = $config->get('pkform_contact_confirmation_message') ? $config->get('pkform_contact_confirmation_message') : "This is the message";

    $name = $form_state->getValue('first_name') . ' ' . $form_state->getValue('last_name');
    $message = str_replace('@contact', $name, $confirmation_message);

    $response = new AjaxResponse();
    $response->addCommand(
      new HtmlCommand(
        '#pkform', $message
      )
    );

    return $response;
  }

}