<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Modules\Docs;

use Arikaim\Core\Extension\Module;

/**
 * Docs module class
 */
class Docs extends Module
{  
    /**
     * Install module
     *
     * @return void
     */
    public function install()
    {
        $this->registerService('DocsGenerator');
    }
}
