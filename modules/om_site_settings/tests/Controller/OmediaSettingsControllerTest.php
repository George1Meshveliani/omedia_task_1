<?php

namespace Drupal\om_site_settings\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the om_site_settings module.
 */
class OmediaSettingsControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "om_site_settings OmediaSettingsController's controller functionality",
      'description' => 'Test Unit for module om_site_settings and controller OmediaSettingsController.',
      'group' => 'Other',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Tests om_site_settings functionality.
   */
  public function testOmediaSettingsController() {
    // Check that the basic functions of module om_site_settings.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
