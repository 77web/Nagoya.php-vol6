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
     * @param array $entryIds
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function makeLessonMock($day, $entryIds)
    {
        $lesson = $this->getMockBuilder('\Nagoya\Data\Lesson')->disableOriginalConstructor()->getMock();
        $members = [];
        foreach ($entryIds as $entryId) {
            $members[] = $this->makeEntryMock($entryId);
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
     * @param int $entryId
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function makeEntryMock($entryId)
    {
        $entry = $this->getMockBuilder('\Nagoya\Data\Entry')->disableOriginalConstructor()->getMock();
        $entry
            ->expects($this->once())
            ->method('getStaffId')
            ->will($this->returnValue($entryId))
        ;

        return $entry;
    }
}
