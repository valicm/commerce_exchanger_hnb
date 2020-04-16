<?php

namespace Drupal\commerce_exchanger_hnb\Plugin\Commerce\ExchangerProvider;

use Drupal\commerce_exchanger\Plugin\Commerce\ExchangerProvider\ExchangerProviderRemoteBase;
use Drupal\Component\Serialization\Json;

/**
 * Provides the Croatian national bank exchange rates.
 *
 * @CommerceExchangerProvider(
 *   id = "hnb",
 *   label = "Croatian National Bank",
 *   display_label = "Croatian National Bank",
 *   historical_rates = TRUE,
 *   base_currency = "HRK",
 *   refresh_once = TRUE
 * )
 */
class HnbExchanger extends ExchangerProviderRemoteBase {

  /**
   * {@inheritdoc}
   */
  public function apiUrl() {
    return 'http://api.hnb.hr/tecajn/v2';
  }

  /**
   * {@inheritdoc}
   */
  public function getRemoteData($base_currency = NULL) {
    $data = NULL;

    $request = $this->apiClient([]);

    if ($request) {
      $exchanges = Json::decode($request);

      foreach ($exchanges as $exchange) {
        // In upstream add handling with NumberFormatter::formatCurrency
        $data[$exchange['valuta']] = str_replace(',', '.', $exchange['srednji_tecaj']);
      }
    }

    return $data;
  }

}
