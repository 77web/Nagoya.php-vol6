<?php

namespace Nagoya;

use Nagoya\Util\InputParser;

class EnglishClass
{
    /**
     * @var Util\InputParser
     */
    private $inputParser;

    public function __construct(InputParser $inputParser)
    {
        $this->inputParser = $inputParser;
    }

    /**
     * @param string $input
     * @return string
     */
    public function run($input)
    {
        // 入力文字列をStaffの配列に変換する
        // $staffs = $this->inputParser->convertToStaffs($input);

        // 割り振りを行う
        // $classes = $this->classGenerator->generate($staffs);

        // 出力を整える
        // $output = $this->outputFormatter->format($classes);
        // return $output;
    }
}
