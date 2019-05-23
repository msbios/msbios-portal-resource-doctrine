<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Portal\Resource\Doctrine;

use Doctrine\ORM\Mapping as ORM;
use MSBios\Resource\Doctrine\EntityInterface;
use MSBios\Resource\Doctrine\IdentifierableAwareInterface;
use MSBios\Resource\Doctrine\IdentifierAwareTrait;

/**
 * Class Entity
 *
 * @package MSBios\Portal\Resource\Doctrine
 * @ORM\MappedSuperclass
 */
abstract class Entity implements EntityInterface, IdentifierableAwareInterface
{
    use IdentifierAwareTrait;
}
