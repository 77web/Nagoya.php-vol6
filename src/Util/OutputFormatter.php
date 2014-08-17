<?php


namespace Nagoya\Util;


class OutputFormatter
{
    /**
     * @param \Nagoya\Data\Lesson[] $lessons
     * @return string
     */
    public function format(array $lessons)
    {
        $outputs = [];
        foreach ($lessons as $lesson) {
            $staffIds = [];
            foreach ($lesson->getMembers() as $staff) {
                $staffIds[] = $staff->getId();
            }
            sort($staffIds);

            $outputs[] = sprintf('%d_%s', $lesson->getDay(), implode(':', $staffIds));
        }

        return implode('|', $outputs);
    }
}
