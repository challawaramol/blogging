<?php

namespace Drupal\john\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\node\Entity\Node;

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
        '#theme' => 'popular-node-block',
        '#nodes_build' => $this->getNodesBuild(),
        '#cache' => array(
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

  /**
   * This function return view_builder of list of nodes.
   * @return array
   */
  protected  function  getNodesBuild(){
    //- Replace this by the result of your Query
     $bundle ='article';
    $query = \Drupal::entityQuery('node')
    ->condition('status', 1)
    ->condition('type', $bundle)
    ->sort('created', 'DESC')
    ->pager(5);
    $nids = $query->execute();
    //- Get the current lang
    $language_manager = \Drupal::service('language_manager');
    $language = $language_manager->getCurrentLanguage()->getId();
    //- Get view_builder for node entity type
    $entity_type_manager = \Drupal::service('entity_type.manager');
    $view_builder = $entity_type_manager->getViewBuilder('node');
    //- Load nodes
    $nodes = Node::loadMultiple($nids);
    return $view_builder->viewMultiple($nodes, 'teaser', $language);
  }

}