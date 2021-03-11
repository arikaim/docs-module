<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/

/** 
 * @Annotation 
*/
class ApiParameter 
{  
    /** @var string */
    public $name;

    /** @var string */
    public $type;

    /** @var string */
    public $description;
    
    /** @var bool */
    public $required;

    /** @var mixed */
    public $default;
}
