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
     * @var Staff[]
     *
     * 受講する社員リスト
     */
    private $members;

    /**
     * @var int
     *
     * 受講生の定員
     */
    private $memberLimit;

    /**
     * @param int $day
     * @param int $memberLimit
     */
    public function __construct($day, $memberLimit)
    {
        $this->day = $day;
        $this->memberLimit = $memberLimit;
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
     * @return Staff[]
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

    public function removeMember(Staff $staff)
    {
        foreach ($this->members as $key => $member) {
            if ($member->getId() == $staff->getId()) {
                unset($this->members[$key]);
                break;
            }
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isFull()
    {
        return count($this->members) >= $this->memberLimit;
    }
}
