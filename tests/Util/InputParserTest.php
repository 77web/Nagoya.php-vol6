<?php


namespace Nagoya\Util;

use Nagoya\Data\Staff;

class InputParserTest extends \PHPUnit_Framework_TestCase 
{
    /**
     * @test
     * @dataProvider provideTestData
     */
    public function test_convertToStaffs($input, $size, Staff $expectedStaff1)
    {
        $inputParser = new InputParser();
        $staffs = $inputParser->convertToStaffs($input);

        $this->assertInternalType('array', $staffs);
        $this->assertEquals($size, count($staffs));
        $this->assertEquals($expectedStaff1, $staffs[0]);
    }

    /**
     * @return array
     */
    public function provideTestData()
    {
        $staff1 = new Staff(1);
        $staff1->setClassDayRequests([1,2,3,4,5]);

        return [
            ['1_12345|2_12345', 2, $staff1],
        ];
    }
}
