<?php


class Products extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;
     
    /**
     *
     * @var integer
     */
    public $type_id;
     
    /**
     *
     * @var string
     */
    public $name;
     
    /**
     *
     * @var string
     */
    public $price;
     
    /**
     *
     * @var integer
     */
    public $quantity;
     
    /**
     *
     * @var string
     */
    public $status;
     
}
