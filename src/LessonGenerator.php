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
     */
    public function __construct(array $days = [])
    {
        $this->lessonDays = $days;
    }

    /**
     * @param \Nagoya\Data\Staff[] $staffs
     * @return array
     */
    public function generate(array $staffs)
    {
        $lessons = $this->initializeLessons();

        // 社員をクラスに割り振る
        foreach ($staffs as $staff) {
            /// TODO 希望順・応募順・定員を考慮する
            $day = $staff->getFirstRequest();

            // TODO $lessonの特定をRepositoryに任せる
            $lessons[$day]->addMember($staff);
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
            $lessons[$day] = new Lesson($day);
        }

        return $lessons;
    }
}
