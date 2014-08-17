<?php


namespace Nagoya\Util;


class OutputFormatterTest extends \PHPUnit_Framework_TestCase 
{
    /**
     * @test
     * @dataProvider provideTestData
     */
    public function test_format($lessons, $expectedOutput)
    {
        $outputFormatter = new OutputFormatter();
        $output = $outputFormatter->format($lessons);

        $this->assertEquals($expectedOutput, $output);
    }

    /**
     * @return array
     */
    public function provideTestData()
    {
        $lesson1 = $this->makeLessonMock(1, [1]);
        $lesson2 = $this->makeLessonMock(1, [1]);
        $lesson3 = $this->makeLessonMock(2, [3, 2]);

        return [
            [[$lesson1], '1_1'],
            [[$lesson2, $lesson3], '1_1|2_2:3'],
        ];
    }

    /**
     * @param int $day
     * @param array $staffIds
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function makeLessonMock($day, $staffIds)
    {
        $lesson = $this->getMockBuilder('\Nagoya\Data\Lesson')->disableOriginalConstructor()->getMock();
        $members = [];
        foreach ($staffIds as $staffId) {
            $members[] = $this->makeStaffMock($staffId);
        }

        $lesson
            ->expects($this->once())
            ->method('getDay')
            ->will($this->returnValue($day))
        ;
        $lesson
            ->expects($this->once())
            ->method('getMembers')
            ->will($this->returnValue($members))
        ;

        return $lesson;
    }

    /**
     * @param int $id
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function makeStaffMock($id)
    {
        $staff = $this->getMockBuilder('\Nagoya\Data\Staff')->disableOriginalConstructor()->getMock();
        $staff
            ->expects($this->once())
            ->method('getId')
            ->will($this->returnValue($id))
        ;

        return $staff;
    }
}
