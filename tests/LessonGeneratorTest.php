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

        $lessonGenerator = new LessonGenerator($days, 4);
        $lessons = $lessonGenerator->generate($staffs);

        $this->assertInternalType('array', $lessons);
        $this->assertEquals(1, count($lessons));

        $lesson = reset($lessons);
        $this->assertEquals(2, $lesson->getDay());
        $this->assertEquals(2, count($lesson->getMembers()));
    }

    /**
     * @test
     */
    public function generate_第一希望順で定員オーバーが発生した場合の割り振り()
    {
        $staffs = [];
        for ($i = 1; $i <= 3; $i++) {
            $staffs[] = $this->makeStaffMock($i, [1,2]);
        }

        $lessonGenerator = new LessonGenerator([1,2], 1);
        $lessons = $lessonGenerator->generate($staffs);

        $this->assertEquals(2, count($lessons));

        // 社員1が曜日1 社員2が曜日2に割り振られ、社員3はお断り
        for ($i = 1; $i <= 2; $i++) {
            $members = $lessons[$i]->getMembers();
            $this->assertEquals(1, count($members));
            $this->assertEquals($i, $members[0]->getId());
        }
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

        return $staff;
    }
}
