<?php

namespace Lianni\Listener;

use Phalcon\Events\Event;
use Phalcon\Mvc\Model\Manager;

class ModelsManager
{
    public function afterInitialize(Event $event, Manager $manager, $model)
    {
        //Reflector
        $reflector = $this->annotations->get($model);
        /**
         * Read the annotations in the class' docblock
         */
        $annotations = $reflector->getClassAnnotations();
        if ($annotations) {
            /**
             * Traverse the annotations
             */
            foreach ($annotations as $annotation) {
                switch ($annotation->getName()) {
                    /**
                     * Initializes the model's source
                     */
                    case 'Source':
                        $arguments = $annotation->getArguments();
                        $manager->setModelSource($model, $arguments[0]);
                        break;
                    /**
                     * Initializes Has-Many relations
                     */
                    case 'HasMany':
                        $arguments = $annotation->getArguments();
                        if (isset($arguments[3])) {
                            $manager->addHasMany($model, $arguments[0], $arguments[1], $arguments[2], $arguments[3]);
                        } else {
                            $manager->addHasMany($model, $arguments[0], $arguments[1], $arguments[2]);
                        }
                        break;
                    /**
                     * Initializes BelongsTo relations
                     */
                    case 'BelongsTo':
                        $arguments = $annotation->getArguments();
                        if (isset($arguments[3])) {
                            $manager->addBelongsTo($model, $arguments[0], $arguments[1], $arguments[2], $arguments[3]);
                        } else {
                            $manager->addBelongsTo($model, $arguments[0], $arguments[1], $arguments[2]);
                        }
                        break;
                }
            }
        }
        return $event->getType();
    }
}