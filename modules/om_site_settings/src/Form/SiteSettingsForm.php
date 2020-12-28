<?php


namespace Drupal\om_site_settings\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\ConfigManager;
use Drupal\Core\Config\ExtensionInstallStorage;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Link;


/**
 * Class SiteSettingsForm.
 *
 * Copyright (C) 2020 Omedia <welcome@omedia.dev>.
 *
 * Omedia/OAS-API can not be copied and/or
 * distributed without the express permission of Omedia.
 *
 * Written by Temuri Takalandze <takalandzet@gmail.com>, April 2020
 *
 * Class is used and modified by George Meshveliani member of Temuri Takalandze team.
 *
 * @package Drupal\om_site_settings\Form
 */
class SiteSettingsForm extends ConfigFormBase
{

  /**
   * Drupal\Core\Config\ConfigManager definition.
   *
   * @var \Drupal\Core\Config\ConfigManager
   */

  protected $configManager;

  /**
   * Drupal\Core\Config\ExtensionInstallStorage definition.
   *
   * @var \Drupal\Core\Config\ExtensionInstallStorage
   */
  protected $configStorageSchema;

  /**
   * Constructs a new GeneralSettingsForm object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   ConfigFactory Instance.
   * @param \Drupal\Core\Config\ConfigManager $config_manager
   *   ConfigManager Instance.
   * @param \Drupal\Core\Config\ExtensionInstallStorage $config_storage_schema
   *   ExtensionInstallStorage Instance.
   */
  public function __construct(
    ConfigFactoryInterface $config_factory,
    ConfigManager $config_manager,
    ExtensionInstallStorage $config_storage_schema
  )
  {
    parent::__construct($config_factory);
    $this->configManager = $config_manager;
    $this->configStorageSchema = $config_storage_schema;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('config.factory'),
      $container->get('config.manager'),
      $container->get('config.storage.schema')
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames()
  {
    return [
      'om_site_settings.site_settings',
    ];
  }

  /**
   * {@inheritdoc}
   */

  public function getFormId()
  {
    return 'site_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {

    $config = $this->config('om_site_settings.site_settings');

    $form['archive_length'] = [
      '#type' => 'number',
      '#title' => $this->t('Archive Length'),
      '#description' => $this->t('Input number from 1 to 100'),
      '#default_value' => $config->get('archive_length'),
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
      '#default_value' => $config->get('website_code'),
      '#weight' => '1',
      // Partial Validation - Website Code
      '#maxlength' => 8,
      '#required' => true,
    ];
    $form['website_description'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Website Description'),
      '#description' => $this->t('Describe the website(Optional)'),
      '#format' => $config->get('website_description')['format'] ?? 'full_html',
      '#default_value' => $config->get('website_description')['value'] ?? '',
      '#weight' => '1',
      '#required' => true,
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */


    public function validateForm(array &$form, FormStateInterface $form_state) {
    //  Fulfilled Validation - Website Code
    $website_code = $form_state->getValue('website_code');
    if (substr($website_code, 0, 3) !== "OM-") {
      $form_state->setErrorByName(
        'website_code',
        $this->t("Website Code should start with 'OM-' e.g: 'OM-12345'")
      );
    }
    if (
      strlen($website_code) < 8
      || !is_numeric(substr($website_code, 3, 5))
    ) {
      $form_state->setErrorByName(
        'website_code',
        $this->t("Input should contain 5 numbers e.g: 'OM-12345'")
      );
    }

    parent::validateForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    parent::submitForm($form, $form_state);

    $fields = [
      'archive_length',
      'website_code',
      'website_description',
    ];

    foreach ($fields as $field_key) {
      $this->config('om_site_settings.site_settings')
        ->set($field_key, $form_state->getValue($field_key))
        ->save();

    }


      \Drupal::messenger()->addMessage(
        "To see results go to: Omedia Site Settings section"
      );


  }
}

