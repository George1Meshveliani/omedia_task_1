<?php

namespace Drupal\om_site_settings\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class OmediaSettingsController.
 */
class OmediaSettingsController extends ControllerBase {


  public function buildController() {

    $config = $this->config('om_site_settings.site_settings');
    $archive_length = $config->get('archive_length');
    $website_code = $config->get('website_code');
    $website_description = strip_tags($config->get('website_description')['value']);

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t("
    <table>
	      <caption>Last changes</caption>
	      <thead>
	          <tr>
		            <th>Archive Length:</th>
		            <th>Website Code:</th>
		            <th>Website Description:</th>
	          </tr>
	      </thead>

	      <tbody>
	          <tr>
		            <td>@archive_length</td>
		            <td>@website_code</td>
		            <td>@website_description</td>
	          </tr>
	      </tbody>
    </table>    ",
        [
        '@archive_length' => $archive_length,
        '@website_code' => $website_code,
        '@website_description' => $website_description,
      ]),
    ];

    return $build;
  }

}
