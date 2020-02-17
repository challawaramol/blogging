<?php
namespace Drupal\john\EventSubscriber;
 
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Drupal\Core\Url;
/**
 * Redirect .html pages to corresponding Node page.
 */
class CustomredirectSubscriber implements EventSubscriberInterface {
 
  /** @var int */
  private $redirectCode = 301;

   public function __construct() {
   
 }
 
  /**
   * Redirect pattern based url
   * @param GetResponseEvent $event
   */
  public function customRedirection(GetResponseEvent $event) {
 
    $request = \Drupal::request();
    $requestUrl = $request->server->get('REQUEST_URI', null);
    
    /**
     * Here i am redirecting the / to respective /country side .
     */
    $countryCode = $this->getCountryCodeByIp();
       
    if ($requestUrl=='/' && $countryCode =='in') { //indi redirection
        $response = new RedirectResponse('/hi', $this->redirectCode);
        $response->send();
        exit(0);
    }
    if ($requestUrl=='/' &&  $countryCode =='pk') { //pak redirection
        $response = new RedirectResponse('/ur', $this->redirectCode);
        $response->send();
        exit(0);
    }
  }
  /**
   * Get country code by ip address
   */
  function getCountryCodeByIp($ip=null){
    //$ip = "172.217.166.4"; // USA
    //$ip = "125.99.114.130"; // India
    //$ip = "27.96.95.255"; // pakistan
    $ip =  $_SERVER['REMOTE_ADDR'];
    $ip_data = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));
     if($ip_data && $ip_data->geoplugin_countryName != null){
         $result['countryCode'] = $ip_data->geoplugin_countryCode;
         
     }
     return strtolower($result['countryCode']);
   }
  /**
   * Listen to kernel.request events and call customRedirection.
   * {@inheritdoc}
   * @return array Event names to listen to (key) and methods to call (value)
   */
  public static function getSubscribedEvents() {
    $events = [];
    //$events[KernelEvents::REQUEST][] = ['onRouteMatch', 27];
    $events[KernelEvents::REQUEST][] = array('customRedirection');
    return $events;
  }
}