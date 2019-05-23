<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Portal\Resource\Doctrine;

use Doctrine\ORM\Mapping as ORM;
use MSBios\Doctrine\IdentifierAwareTrait;

/**
 * Class Entity
 *
 * @package MSBios\Portal\Resource\Doctrine
 * @ORM\MappedSuperclass
 */
abstract class Entity extends \MSBios\Doctrine\Entity
{
    use IdentifierAwareTrait;
}
