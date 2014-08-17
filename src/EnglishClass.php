<?php

namespace Nagoya;

use Nagoya\Util\InputParser;
use Nagoya\Util\OutputFormatter;

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

    /**
     * @var OutputFormatter
     */
    private $outputFormatter;

    public function __construct(InputParser $inputParser, LessonGenerator $lessonGenerator, OutputFormatter $outputFormatter)
    {
        $this->inputParser = $inputParser;
        $this->lessonGenerator = $lessonGenerator;
        $this->outputFormatter = $outputFormatter;
    }

    /**
     * @param string $input
     * @return string
     */
    public function run($input)
    {
        // 入力文字列をStaffの配列に変換する
        $entries = $this->inputParser->convertToEntries($input);

        // 割り振りを行う
        $lessons = $this->lessonGenerator->generate($entries);

        // 出力を整える
        $output = $this->outputFormatter->format($lessons);

        return $output;
    }
}
