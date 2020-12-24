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
      // Complete Validation - Archive Length
      '#min' => '1',
      '#max' => '100',
    ];
    $form['website_code'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Website Code'),
      '#description' => $this->t('Enter website code'),
      '#size' => 9,
      '#default_value' => 'OM-00000',
      '#weight' => '1',
      // Partial Validation - Website Code
      '#maxlength' => 8,
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
     //  Fulfilled Validation - Website Code

      $website_code = $form_state->getValue('website_code');

    if (substr($website_code, 0, 3) !== "OM-")  {
      $form_state->setErrorByName('website_code', $this->t("Website Code should start with 'OM-' e.g: 'OM-12345'"));
    }

    if (strlen($website_code) < 8 || !is_numeric(substr($website_code, 3, 5))) {
      $form_state->setErrorByName('website_code', $this->t("Input should contain 5 numbers e.g: 'OM-12345'"));
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
