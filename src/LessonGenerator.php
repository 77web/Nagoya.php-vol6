<?php


namespace Nagoya;


use Nagoya\Data\Lesson;
use Nagoya\Data\Staff;

class LessonGenerator
{
    /**
     * @var array
     */
    private $lessonDays;

    /**
     * @param array $days
     * @param int $memberLimit
     */
    public function __construct(array $days = [], $memberLimit)
    {
        $this->lessonDays = $days;
        $this->memberLimit = $memberLimit;
    }

    /**
     * @param \Nagoya\Data\Staff[] $staffs
     * @return array
     */
    public function generate(array $staffs)
    {
        $lessons = $this->initializeLessons();

        // 社員をクラスに割り振る
        // 社員は応募順に並べられている
        foreach ($staffs as $staff) {
            $this->assignStaffToLesson($staff, $lessons);
        }

        // 受講生のいない枠を削除
        // FIXME
        foreach ($lessons as $day => $lesson) {
            if (0 === count($lesson->getMembers())) {
                unset($lessons[$day]);
            }
        }

        return $lessons;
    }

    /**
     * @return Lesson[]
     */
    private function initializeLessons()
    {
        $lessons = [];
        foreach ($this->lessonDays as $day) {
            $lessons[$day] = new Lesson($day, $this->memberLimit);
        }

        return $lessons;
    }

    /**
     * @param Staff $staff
     * @param Lesson[] $lessons
     */
    private function assignStaffToLesson(Staff $staff, array $lessons)
    {
        // 希望順に各曜日の空きを見て行き、空きがあればその時点でクラスに参加させる
        foreach ($staff->getClassDayRequests() as $day) {
            // TODO クラスの特定方法をRepositoryとかに任せる
            $lesson = $lessons[$day];

            if (!$lesson->isFull()) {
                $lesson->addMember($staff);
                break;
            } else {
                // 実行時点で一番希望順位が低い社員を見つける。同じ希望順なら応募順が後の方を低いと見なす
                $minimumPriorityMember = null;
                foreach ($lesson->getMembers() as $member) {
                    /** @var Staff $minimumPriorityMember */
                    if (null === $minimumPriorityMember || $member->getRequestRankForDay($day) >= $minimumPriorityMember->getRequestRankForDay($day)) {
                        $minimumPriorityMember = $member;
                    }
                }

                // 一番希望順位が低い社員が現在アサイン実行中の社員より希望順位が低ければ追い出して再アサイン
                if ($minimumPriorityMember->getRequestRankForDay($day) > $staff->getRequestRankForDay($day)) {
                    $lesson
                        ->addMember($staff)
                        ->removeMember($minimumPriorityMember)
                    ;

                    $this->assignStaffToLesson($minimumPriorityMember, $lessons);
                    break;
                }
            }
        }
    }
}
