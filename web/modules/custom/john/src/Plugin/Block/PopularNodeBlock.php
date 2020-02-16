<?php

namespace Drupal\john\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;

/**
* Provides a 'PopularNodeBlock' block.
*
* @Block(
*  id = "popular_node_block",
*  admin_label = @Translation("Popular Node block"),
* )
*/
class PopularNodeBlock extends BlockBase {

 /**
  * {@inheritdoc}
  */
 public function build() {
    $build = array(
        '#type' => 'markup',
        '#markup' => '<p>custom Block<p>',
        '#cache' => array(
         // 'tags' => $this->getCacheTags(),
          //'contexts' => $this->getCacheContexts(),
        	'max-age' => '86400' 
        ),
      );

   return $build;
 }

 /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    return Cache::mergeContexts(parent::getCacheContexts(), ['user.node_grants:view']);
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    return Cache::mergeTags(parent::getCacheTags(), ['node_list']);
  }

}