<?php


namespace Nagoya;


class LessonGeneratorTest extends \PHPUnit_Framework_TestCase 
{
    public function test_generate()
    {
        $staff1 = $this->makeStaffMock(1, [2, 1]);
        $staff2 = $this->makeStaffMock(2, [2]);
        $days = [1, 2];
        $staffs = [$staff1, $staff2];

        $lessonGenerator = new LessonGenerator($days);
        $lessons = $lessonGenerator->generate($staffs);

        $this->assertInternalType('array', $lessons);
        $this->assertEquals(1, count($lessons));

        $lesson = reset($lessons);
        $this->assertEquals(2, $lesson->getDay());
        $this->assertEquals(2, count($lesson->getMembers()));
    }

    /**
     * @param int $id
     * @param array $requestDays
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function makeStaffMock($id, $requestDays)
    {
        $staff = $this->getMockBuilder('\Nagoya\Data\Staff')->disableOriginalConstructor()->getMock();
        $staff
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($id))
        ;
        $staff
            ->expects($this->any())
            ->method('getClassDayRequests')
            ->will($this->returnValue($requestDays))
        ;
        $staff
            ->expects($this->once())
            ->method('getFirstRequest')
            ->will($this->returnValue(reset($requestDays)))
        ;

        return $staff;
    }
}
