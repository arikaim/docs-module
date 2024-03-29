<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Modules\Docs\Service;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

use Arikaim\Core\Service\Service;
use Arikaim\Core\Service\ServiceInterface;
use ReflectionClass;

/**
 * DocsGenerator service class
*/
class DocsGenerator extends Service implements ServiceInterface
{
    /**
     * Init service
    */
    public function boot()
    {
        $this->setServiceName('docs');
    }

    /**
     * Get class api doc info
     *
     * @param string $class
     * @param string $methodName
     * @return array|null
     */
    public function getClassInfo(string $class, string $methodName): ?array
    {
        global $arikaim;

        $arikaim->get('class.loader')->LoadClassFile('Arikaim\Modules\Docs\Annotations\ApiParameter');
        $arikaim->get('class.loader')->LoadClassFile('Arikaim\Modules\Docs\Annotations\Api');
        $arikaim->get('class.loader')->LoadClassFile('Arikaim\Modules\Docs\Annotations\ApiResponse');
      
        AnnotationRegistry::loadAnnotationClass('Api');  
        AnnotationRegistry::loadAnnotationClass('ApiParameter');  
        AnnotationRegistry::loadAnnotationClass('ApiResponse');  
       
        $reflection = new ReflectionClass($class);
        if ($reflection->hasMethod($methodName) == false) {
            return null;
        }
    
        $method = $reflection->getMethod($methodName);

        $reader = new AnnotationReader();
        $items = $reader->getMethodAnnotations($method);
        if (\is_array($items) == false) {
            return null;
        }

        $result = [];
        foreach($items as $item) {
            if (\get_class($item) == 'Api') {              
                $result['api'] = $item;               
            }
            if (\get_class($item) == 'ApiResponse') {                       
                $result['response'] = $item;
            }
        }
       
        return $result;
    }

    /**
     * Get controller api doc info
     *
     * @param string $class
     * @param string $methodName
     * @return array|null
     */
    public function getControllerInfo(string $class, string $methodName): ?array
    {   
        $result = $this->getClassInfo($class,$methodName);

        return ($result == null) ? $this->getClassInfo($class,$methodName . 'Controller') : $result;         
    }
}
