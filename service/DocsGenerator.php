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

use Arikaim\Core\Utils\Path;
use Arikaim\Core\Service\Service;
use Arikaim\Core\Service\ServiceInterface;
use ReflectionClass;

/**
 * DocsGenerator service class
*/
class DocsGenerator extends Service implements ServiceInterface
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setServiceName('docs');  
    }

    /**
     * Undocumented function
     *
     * @param string $class
     * @param string $methodName
     * @return array|null
     */
    public function getControllerInfo(string $class, string $methodName): ?array
    {   
        AnnotationRegistry::registerFile(Path::MODULES_PATH . 'docs/Annotations/ApiParameter.php');  
        AnnotationRegistry::registerFile(Path::MODULES_PATH . 'docs/Annotations/ApiResponse.php');
        AnnotationRegistry::registerFile(Path::MODULES_PATH . 'docs/Annotations/Api.php');
       
        $reflection = new ReflectionClass($class);
        $methodName = ($reflection->hasMethod($methodName) == false) ? $methodName .'Controller' : $methodName;
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
}
