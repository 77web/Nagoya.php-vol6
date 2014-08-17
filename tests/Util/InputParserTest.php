<?php


namespace Nagoya\Util;

use Nagoya\Data\Entry;

class InputParserTest extends \PHPUnit_Framework_TestCase 
{
    /**
     * @test
     * @dataProvider provideTestData
     */
    public function test_convertToEntries($input, $size, Entry $expectedEntry1)
    {
        $inputParser = new InputParser();
        $entries = $inputParser->convertToEntries($input);

        $this->assertInternalType('array', $entries);
        $this->assertEquals($size, count($entries));
        $this->assertInstanceOf('\Nagoya\Data\Entry', $entries[0]);
        $this->assertEquals($expectedEntry1->getStaffId(), $entries[0]->getStaffId());
    }

    /**
     * @return array
     */
    public function provideTestData()
    {
        $staff1 = new Entry(1, 1);
        $staff1->setClassDayRequests([1,2,3,4,5]);

        return [
            ['1_12345|2_12345', 2, $staff1],
        ];
    }
}
