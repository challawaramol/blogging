<?php

namespace Drupal\john\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;

/**
 * Class DisplayTableController.
 *
 * @package Drupal\john\Controller
 */
class DisplayTableController extends ControllerBase {


  /**
   * Display.
   *
   * @return string
   *   Return Hello string.
   */
  public function display() {
    
       
        $ip_address = \Drupal::request()->getClientIp();
        print_r($ip_address);
        $ipl = ip2long($ip_address);
  if (is_long($ip_address)) {
    $ipl = $ip_address;
  }
$ipl = $ip_address;
  // Locate IP within range.
  $sql    = "SELECT country FROM {ip2country}
             WHERE (:start >= ip_range_first AND :end <= ip_range_last) LIMIT 1";
  $result = db_query($sql, [':start' => $ipl, ':end' => $ipl])->fetchField();

  print_r($result);die;

  }

}
