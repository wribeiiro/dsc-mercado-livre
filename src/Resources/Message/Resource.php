<?php

/**
 * Class Resource
 *
 * @author Diego Wagner <diegowagner4@gmail.com>
 * http://www.discoverytecnologia.com.br
 */

namespace Dsc\MercadoLivre\Resources\Message;

use JMS\Serializer\Annotation as JMS;

class Resource
{
    /**
     * @var string
     * @JMS\Type("string")
     */
    private $id;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $name;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return MessageResource
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return MessageResource
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}
