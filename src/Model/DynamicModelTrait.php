<?php
/**
 * Created by PhpStorm.
 * User: kost
 * Date: 05.07.2018
 * Time: 10:09
 */

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;

trait DynamicModelTrait
{
    /**
     * @var array
     * @ORM\Column( type="array", nullable=true, unique=false )
     */
    private $entityDynamicData = [];

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
