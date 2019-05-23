<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbiosc.com>
 */
namespace MSBios\Portal\Resource\Doctrine;

/**
 * Class Module
 * @package MSBios\Portal\Resource\Doctrine
 */
class Module extends \MSBios\Module
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
}
