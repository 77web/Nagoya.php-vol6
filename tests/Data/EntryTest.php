<?php


namespace Nagoya\Data;


class EntryTest extends \PHPUnit_Framework_TestCase
{
    public function test_getRequestRankForDay()
    {
        $requests = [1, 2];

        $entry = new Entry(1, 1);
        $entry->setClassDayRequests($requests);

        $this->assertEquals(1, $entry->getRequestRankForDay(1));
        $this->assertEquals(2, $entry->getRequestRankForDay(2));
    }
}
