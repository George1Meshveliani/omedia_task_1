<?php

namespace Drupal\om_site_settings\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SiteSettingsForm.
 */
class SiteSettingsForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'site_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['archive_length'] = [
      '#type' => 'number',
      '#title' => $this->t('Archive Length'),
      '#description' => $this->t('Input number from 1 to 100'),
      '#default_value' => '1',
      '#weight' => '1',
    ];
    $form['website_code'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Website Code'),
      '#description' => $this->t('Enter website code'),
      '#maxlength' => 8,
      '#size' => 9,
      '#default_value' => 'OM-00000',
      '#weight' => '1',
    ];
    $form['website_description'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Website Description'),
      '#description' => $this->t('Describe the website'),
      '#weight' => '1',
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    foreach ($form_state->getValues() as $key => $value) {
      // @TODO: Validate fields.
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    foreach ($form_state->getValues() as $key => $value) {
      \Drupal::messenger()->addMessage($key . ': ' . ($key === 'text_format'?$value['value']:$value));
    }
  }

}
