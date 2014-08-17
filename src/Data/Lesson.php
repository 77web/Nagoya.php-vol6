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
     * @var Entry[]
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
     * @return Entry[]
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * @param Entry $entry
     * @return $this
     */
    public function addMember(Entry $entry)
    {
        $this->members[] = $entry;

        return $this;
    }

    public function removeMember(Entry $entry)
    {
        foreach ($this->members as $key => $member) {
            if ($member->getStaffId() == $entry->getStaffId()) {
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
