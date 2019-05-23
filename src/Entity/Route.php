<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Portal\Resource\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use MSBios\Portal\Resource\Doctrine\Entity;
use MSBios\Resource\Doctrine\RowStatusableAwareInterface;
use MSBios\Resource\Doctrine\RowStatusableAwareTrait;
use MSBios\Resource\Doctrine\TimestampableAwareInterface;
use MSBios\Resource\Doctrine\TimestampableAwareTrait;
use MSBios\Resource\Doctrine\TitleableAwareInterface;
use MSBios\Resource\Doctrine\TitleableAwareTrait;

/**
 * Class Route
 * @package MSBios\Portal\Resource\Doctrine\Entity
 *
 * @ORM\Entity(repositoryClass="MSBios\Portal\Resource\Doctrine\Repository\RouteRepository")
 * @ORM\Table(name="sys_t_routes")
 */
class Route extends Entity implements
    TitleableAwareInterface,
    TimestampableAwareInterface,
    RowStatusableAwareInterface
{
    use TitleableAwareTrait;
    use TimestampableAwareTrait;
    use RowStatusableAwareTrait;
}
