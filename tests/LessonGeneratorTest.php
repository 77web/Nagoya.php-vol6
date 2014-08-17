<?php


namespace Nagoya;


class LessonGeneratorTest extends \PHPUnit_Framework_TestCase 
{
    public function test_generate()
    {
        $entry1 = $this->makeEntryMock(1, 1, [2, 1]);
        $entry2 = $this->makeEntryMock(2, 2, [2]);
        $days = [1, 2];
        $entries = [$entry1, $entry2];

        $lessonGenerator = new LessonGenerator($days, 4);
        $lessons = $lessonGenerator->generate($entries);

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
        $entries = [];
        for ($i = 1; $i <= 3; $i++) {
            $entries[] = $this->makeEntryMock($i, $i - 1, [1,2]);
        }

        $lessonGenerator = new LessonGenerator([1,2], 1);
        $lessons = $lessonGenerator->generate($entries);

        $this->assertEquals(2, count($lessons));

        // 社員1が曜日1 社員2が曜日2に割り振られ、社員3はお断り
        for ($i = 1; $i <= 2; $i++) {
            $members = $lessons[$i]->getMembers();
            $this->assertEquals(1, count($members));
            $this->assertEquals($i, $members[0]->getStaffId());
        }
    }

    /**
     * @test
     */
    public function generate_追い出しが発生する場合()
    {
        $entries = [];
        for ($i = 1; $i <= 2; $i++) {
            $entries[] = $this->makeEntryMock($i, $i - 1, [1,2]);
        }
        $entries[] = $this->makeEntryMock(3, 2, [2, 1]);
        $entries[] = $this->makeEntryMock(4, 3, [2, 1]);

        $lessonGenerator = new LessonGenerator([1,2], 1);
        $lessons = $lessonGenerator->generate($entries);

        $this->assertEquals(2, count($lessons));

        // 社員1が曜日1 社員3が曜日2に割り振られ、社員2（希望順で社員3に負ける）,社員4（応募順で社員3に負ける）はお断り
        $membersFor1 = $lessons[1]->getMembers();
        $this->assertEquals(1, count($membersFor1));
        $memberFor1 = reset($membersFor1);
        $this->assertEquals(1, $memberFor1->getStaffId());

        $membersFor2 = $lessons[2]->getMembers();
        $this->assertEquals(1, count($membersFor2));
        $memberFor2 = reset($membersFor2);
        $this->assertEquals(3, $memberFor2->getStaffId());
    }

    /**
     * @param int $id
     * @param int $order
     * @param array $requestDays
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function makeEntryMock($id, $order, $requestDays)
    {
        $entry = $this->getMockBuilder('\Nagoya\Data\Entry')->disableOriginalConstructor()->getMock();
        $entry
            ->expects($this->any())
            ->method('getStaffId')
            ->will($this->returnValue($id))
        ;
        $entry
            ->expects($this->any())
            ->method('getRequestOrder')
            ->will($this->returnValue($order))
        ;
        $entry
            ->expects($this->any())
            ->method('getClassDayRequests')
            ->will($this->returnValue($requestDays))
        ;
        $entry
            ->expects($this->any())
            ->method('getRequestRankForDay')
            ->will($this->returnCallback(function($day) use ($requestDays){
                $flip = array_flip($requestDays);

                return $flip[$day] + 1;
            }))
        ;

        return $entry;
    }
}
