<?php

namespace Nagoya;

use Nagoya\Util\InputParser;

class EnglishClass
{
    /**
     * @var Util\InputParser
     */
    private $inputParser;

    /**
     * @var LessonGenerator
     */
    private $lessonGenerator;

    public function __construct(InputParser $inputParser, LessonGenerator $lessonGenerator)
    {
        $this->inputParser = $inputParser;
        $this->lessonGenerator = $lessonGenerator;
    }

    /**
     * @param string $input
     * @return string
     */
    public function run($input)
    {
        // 入力文字列をStaffの配列に変換する
        $staffs = $this->inputParser->convertToStaffs($input);

        // 割り振りを行う
        $lessons = $this->lessonGenerator->generate($staffs);

        // 出力を整える
        // $output = $this->outputFormatter->format($lessons);
        // return $output;
    }
}
