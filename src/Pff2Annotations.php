<?php

namespace pff\modules;

use Minime\Annotations\Interfaces\AnnotationsBagInterface;
use pff\Abs\AModule;
use pff\Iface\IBeforeHook;
use Minime\Annotations\Reader;
use Minime\Annotations\Parser;
use Minime\Annotations\Cache\Arraycache;

class Pff2Annotations extends AModule implements IBeforeHook
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var AnnotationsBagInterface
     */
    private $classAnnotations;

    /**
     * @var AnnotationsBagInterface
     */
    private $methodAnnotations;

    public function __construct()
    {
        $this->reader = new Reader(new Parser(), new ArrayCache());
    }

    /**
     * Executes actions before the Controller
     *
     * @return mixed
     */
    public function doBefore()
    {
        $class_name                    = get_class($this->_controller);
        $this->classAnnotations        = $this->reader->getClassAnnotations($class_name);
        $this->methodAnnotations       = $this->reader->getMethodAnnotations($class_name, $this->_controller->getAction());
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getClassAnnotation($name)
    {
        return $this->classAnnotations->get($name);
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getMethodAnnotation($name)
    {
        return $this->methodAnnotations->get($name);
    }

    public function getAllClassAnnotations()
    {
        return $this->classAnnotations;
    }

    public function getAllMethodAnnotations()
    {
        return $this->methodAnnotations;
    }
}
