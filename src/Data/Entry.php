<?php


namespace Nagoya\Data;


class Entry
{
    /**
     * @var int
     *
     * 社員番号
     */
    private $staffId;

    /**
     * @var int
     *
     * 申し込み受付順
     */
    private $requestOrder;

    /**
     * @var array
     */
    private $classDayRequests;

    /**
     * @param int $id
     * @param int $requestOrder
     */
    public function __construct($id, $requestOrder)
    {
        $this->staffId = $id;
        $this->requestOrder = $requestOrder;
    }

    /**
     * @param array $classDayRequests
     * @return Entry
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
     * @return Entry
     */
    public function setStaffId($id)
    {
        $this->staffId = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getStaffId()
    {
        return $this->staffId;
    }

    /**
     * @param int $requestOrder
     * @return Entry
     */
    public function setRequestOrder($requestOrder)
    {
        $this->requestOrder = $requestOrder;

        return $this;
    }

    /**
     * @return int
     */
    public function getRequestOrder()
    {
        return $this->requestOrder;
    }

    /**
     * 特定の曜日に対する希望順位を返す
     *
     * @param int $day
     * @return int
     */
    public function getRequestRankForDay($day)
    {
        return intval(array_search($day, $this->classDayRequests)) + 1;
    }
}
