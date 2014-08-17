<?php


namespace Nagoya\Data;


class StaffTest extends \PHPUnit_Framework_TestCase
{
    public function test_getRequestRankForDay()
    {
        $requests = [1, 2];

        $staff = new Staff(1);
        $staff->setClassDayRequests($requests);

        $this->assertEquals(1, $staff->getRequestRankForDay(1));
        $this->assertEquals(2, $staff->getRequestRankForDay(2));
    }
}
