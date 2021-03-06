<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Portal\Resource\Doctrine\Form;

use DoctrineModule\Form\Element\ObjectSelect;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use MSBios\Resource\Doctrine\Entity\Module;
use MSBios\Resource\Form\PageTypeForm as DefaultPageTypeForm;

/**
 * Class PageTypeForm
 * @package MSBios\Portal\Resource\Doctrine\Form
 */
class PageTypeForm extends DefaultPageTypeForm implements ObjectManagerAwareInterface
{
    use ProvidesObjectManager;

    const LABEL_GENERATOR_FORMAT = '%s [%s]';

    public function init()
    {
        parent::init();

        $this->add([
            'type' => ObjectSelect::class,
            'name' => 'module',
            'options' => [
                'object_manager' => $this->getObjectManager(),
                'target_class' => Module::class,
                'label_generator' => function (Module $targetEntity) {
                    return sprintf(
                        self::LABEL_GENERATOR_FORMAT,
                        $targetEntity->getTitle(),
                        $targetEntity->getModule()
                    );
                },
            ],
        ]);
    }
}
