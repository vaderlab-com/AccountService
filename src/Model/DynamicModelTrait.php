<?php
/**
 * Created by PhpStorm.
 * User: kost
 * Date: 05.07.2018
 * Time: 10:09
 */

namespace App\Model;


trait DynamicModelTrait
{
    /**
     * @var array
     */
    protected $entityDynamicData;

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    protected function __getData( string $key, $default = null )
    {
        if( !$this->entityDynamicData ) {
            return $default;
        }

        return isset( $this->entityDynamicData[$key] ) ?
            $this->entityDynamicData[$key] : $default;
    }

    /**
     * @param String $key
     * @param $value
     * @return $this
     */
    protected function __setData( String $key, $value )
    {
        if( !$this->entityDynamicData ) {
            $this->entityDynamicData = [];
        }

        $this->entityDynamicData[ $key ] = $value;

        return $this;
    }
}