<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Portal\Resource\Doctrine\Session\SaveHandler;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Persistence\ProvidesObjectManager;
use MSBios\Portal\Resource\Doctrine\Entity\Session;
use Zend\Session\SaveHandler\SaveHandlerInterface;

/**
 * Class DoctrineGateway
 * @package MSBios\Portal\Resource\Doctrine\Session\SaveHandler
 */
class DoctrineGateway implements SaveHandlerInterface
{
    use ProvidesObjectManager;

    /** @var  string Path */
    protected $path;

    /** @var  string Name */
    protected $name;

    /** @var integer Lifetime */
    protected $lifetime;

    /**
     * DoctrineGateway constructor.
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->setObjectManager($objectManager);
    }

    /**
     * Open Session
     *
     * @param  string $path
     * @param  string $name
     * @return bool
     */
    public function open($path, $name)
    {
        $this->path = $path;
        $this->name = $name;
        $this->lifetime = ini_get('session.gc_maxlifetime');
        return true;
    }

    /**
     * Close session
     *
     * @return bool
     */
    public function close()
    {
        return true;
    }

    /**
     * Read session data
     *
     * @param string $id
     * @return string
     */
    public function read($id)
    {
        /** @var Session $entity */
        if ($entity = $this->getObjectManager()->find(Session::class, $id)) {
            if ($entity->getModified() + $entity->getLifetime() > time()) {
                return $entity->getValue();
            }
            $this->destroy($id);
        }

        return '';
    }

    /**
     * Write session data
     *
     * @param string $id
     * @param string $data
     * @return bool
     */
    public function write($id, $data)
    {
        /** Session */
        if (! $entity = $this->getObjectManager()->find(Session::class, $id)) {
            /** @var Session $entity */
            $entity = new Session;
        }

        $entity->setId($id)
            ->setName($this->name)
            ->setValue((string)$data)
            ->setModified(time())
            ->setLifetime($this->lifetime);

        $this->getObjectManager()->persist($entity);
        $this->getObjectManager()->flush();

        return true;
    }

    /**
     * Destroy session
     *
     * @param  string $id
     * @return bool
     */
    public function destroy($id)
    {
        /** @var Session $entity */
        $entity = $this->getObjectManager()->find(Session::class, $id);
        $this->getObjectManager()->remove($entity);
        $this->getObjectManager()->flush();
        return true;
    }

    /**
     * Garbage Collection
     *
     * @param int $maxlifetime
     * @return true
     */
    public function gc($maxlifetime)
    {
        /** @var ArrayCollection $results */
        $results = $this->getObjectManager()
            ->getRepository(Session::class)
            ->findAll();

        /** @var Criteria $criteria */
        $criteria = new Criteria;
        $criteria->andWhere($criteria->expr()->lt('modified', time() + $this->lifetime));

        $this->getObjectManager()->remove($results->matching($criteria));
        $this->getObjectManager()->flush();

        return true;
    }
}
