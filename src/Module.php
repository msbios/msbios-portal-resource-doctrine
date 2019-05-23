<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbiosc.com>
 */
namespace MSBios\Portal\Resource\Doctrine;

use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\ORM\EntityManager;
use Zend\EventManager\EventInterface;
use Zend\EventManager\LazyListenerAggregate;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\Mvc\ApplicationInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class Module
 * @package MSBios\Portal\Resource\Doctrine
 */
class Module extends \MSBios\Module implements BootstrapListenerInterface
{
    /** @const VERSION */
    const VERSION = '1.0.0';

    /**
     * @inheritdoc
     *
     * @return string
     */
    protected function getDir()
    {
        return __DIR__;
    }

    /**
     * @return string
     */
    protected function getNamespace()
    {
        return __NAMESPACE__;
    }

    /**
     * @inheritdoc
     *
     * @param EventInterface $e
     * @return array|void
     * @throws \Doctrine\DBAL\DBALException
     */
    public function onBootstrap(EventInterface $e)
    {
        /** @var ApplicationInterface $target */
        $target = $e->getTarget();

        /** @var ServiceLocatorInterface $serviceManager */
        $serviceManager = $target->getServiceManager();

        /** @var MySqlPlatform $platform */
        $platform = $serviceManager
            ->get(EntityManager::class)
            ->getConnection()
            ->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');

        (new LazyListenerAggregate(
            $serviceManager->get(self::class)['listeners'],
            $serviceManager
        ))->attach($target->getEventManager());
    }
}
