<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/

use Arikaim\Modules\Docs\Annotations\ApiParameter;

/** 
 * @Annotation 
 * @Target({"METHOD"})
*/
class Api 
{  
    /** @var string */
    public $title;

    /** @var string */
    public $description;
 
    /** @var array<ApiParameter> */
    public $parameters;

    /**
     * Construtor
     *
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->description = $values['description'] ?? '';
        $this->title = $values['title'] ?? '';
        $this->parameters = $values['parameters'] ?? [];
    }    
}
