<?php


namespace Nagoya\Data;


class Staff
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var array
     */
    private $classDayRequests;

    /**
     * @param int $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @param array $classDayRequests
     * @return Staff
     */
    public function setClassDayRequests($classDayRequests)
    {
        $this->classDayRequests = $classDayRequests;

        return $this;
    }

    /**
     * @return array
     */
    public function getClassDayRequests()
    {
        return $this->classDayRequests;
    }

    /**
     * @param int $id
     * @return Staff
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getFirstRequest()
    {
        return reset($this->classDayRequests);
    }
}
