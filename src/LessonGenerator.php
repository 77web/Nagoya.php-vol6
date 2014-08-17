<?php


namespace Nagoya;


use Nagoya\Data\Lesson;

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
            foreach ($staff->getClassDayRequests() as $day) {
                // 希望順にクラスの空きを見て行き、空きがあればその時点でクラスに参加させる
                // TODO $lessonの特定をRepositoryとかに任せる
                if (!$lessons[$day]->isFull()) {
                    $lessons[$day]->addMember($staff);
                    break;
                }
            }
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
}
