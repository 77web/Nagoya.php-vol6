<?php


namespace Nagoya\Data;


class Lesson
{
    /**
     * @var int
     *
     * 開講する曜日
     */
    private $day;

    /**
     * @var array
     *
     * 受講する社員リスト
     */
    private $members;

    /**
     * @param int $day
     */
    public function __construct($day)
    {
        $this->day = $day;
    }

    /**
     * @param int $day
     * @return Lesson
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * @return int
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param array $members
     * @return Lesson
     */
    public function setMembers($members)
    {
        $this->members = $members;

        return $this;
    }

    /**
     * @return array
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * @param Staff $staff
     * @return $this
     */
    public function addMember(Staff $staff)
    {
        $this->members[] = $staff;

        return $this;
    }
}
