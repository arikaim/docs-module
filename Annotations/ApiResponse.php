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
use Arikaim\Core\Http\ApiResponse as Response;

/** 
 * @Annotation
*/
class ApiResponse 
{  
    /** @var string */
    public $summary;
    
    /** @var string */
    public $statusCode;

    /** @var array<ApiParameter> */
    public $fields;

    /** @var string */
    public $contentType;

    /**
     * Construtor
     *
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->summary = $values['summary'] ?? null;
        $this->fields = $values['fields'] ?? [];
        $this->contentType = $values['content-type'] ?? 'application/json';
        $this->statusCode =  $values['status-code'] ?? '200';
    }    

    /**
     * Get response
     *
     * @return string
     */
    public function getJson(): string
    {
        $response = new Response();
        $response->useJsonPrettyformat();

        foreach($this->fields as $field) {
            $response->field($field->name, $field->description ?? '');
        }
    
        return $response->getResponseJson();
    }
}
