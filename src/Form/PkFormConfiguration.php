<?php

namespace Drupal\pkform\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

  /**
   * Configure settings for PK Form.
   */

class PkFormConfiguration extends ConfigFormBase {

  /** 
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'pkform_admin_settings';
  }

  /** 
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'pkform.settings',
    ];
  }

  /** 
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('pkform.settings');

    $form['pkform_contact_message'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Contact Message'),
      '#default_value' => $config->get('pkform_contact_message'),
    );

    $form['pkform_contact_confirmation_message'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Contact Confirmation Message'),
      '#default_value' => $config->get('pkform_contact_confirmation_message'),
    );

    return parent::buildForm($form, $form_state);
  }

  /** 
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
      // Retrieve the configuration
       $this->configFactory->getEditable('pkform.settings')
      // Set the submitted configuration setting
      ->set('pkform_contact_message', $form_state->getValue('pkform_contact_message'))
      ->set('pkform_contact_confirmation_message', $form_state->getValue('pkform_contact_confirmation_message'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}