<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Porta\Resource\Doctrine;

use MSBios\Portal\Resource\Doctrine\Session\SaveHandler\DoctrineGateway;
use MSBios\Resource\Doctrine\Module;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;
use Zend\Session\SessionManager;

/**
 * Class ListenerAggregate
 * @package MSBios\Porta\Resource\Doctrine
 */
class ListenerAggregate extends AbstractListenerAggregate
{
    /**
     * @inheritdoc
     *
     * @param EventManagerInterface $events
     * @param int $priority
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_DISPATCH, [$this, 'onDispatch'], -100500
        );
    }

    /**
     * @param EventInterface $e
     */
    public function onDispatch(EventInterface $e)
    {
        /** @var ServiceLocatorInterface $serviceManager */
        $serviceManager = $e->getApplication()
            ->getServiceManager();

        /** @var array $options */
        $options = $serviceManager
            ->get(Module::class)['session'];

        if ($options['enabled']) {

            /** @var SessionConfig $sessionConfig */
            $sessionConfig = new SessionConfig;
            $sessionConfig->setOptions($options['options']);

            /** @var SessionManager $sessionManager */
            $sessionManager = new SessionManager;
            $sessionManager->setConfig($sessionConfig);
            $sessionManager->setSaveHandler(
                $serviceManager->get(DoctrineGateway::class)
            );

            Container::setDefaultManager($sessionManager);
            $sessionManager->start();
        }
    }
}
