<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Portal\Resource\Doctrine\Factory;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use MSBios\Portal\Resource\Doctrine\Session\SaveHandler\DoctrineGateway;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class DoctrineGatewayFactory
 * @package MSBios\Portal\Resource\Doctrine\Factory
 */
class DoctrineGatewayFactory implements FactoryInterface
{
    /**
     * @inheritdoc
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return DoctrineGateway|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new DoctrineGateway(
            $container->get(EntityManager::class)
        );
    }
}
