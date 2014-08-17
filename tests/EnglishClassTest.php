<?php

namespace Nagoya;

use Nagoya\Util\InputParser;

class EnglishClassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @param string $input
     * @param string $expectedOutput
     * @dataProvider provideInputAndOutput
     */
    public function test_actual_run($input, $expectedOutput)
    {
        $inputParser = new InputParser();
        $lessonGenerator = new LessonGenerator([1, 2, 3, 4, 5]);

        $englishClass = new EnglishClass($inputParser, $lessonGenerator);
        $output = $englishClass->run($input);

        // $this->assertEquals($expectedOutput, $output);
    }

    /**
     * @return array
     */
    public function provideInputAndOutput()
    {
        return [
            ['1_12345', '1_1'],
        ];
    }

    /**
     * @test
     */
    public function test_run()
    {
        $staff1 = $this->getMockBuilder('\Nagoya\Data\Staff')->disableOriginalConstructor()->getMock();
        $lesson1 = $this->getMockBuilder('\Nagoya\Data\Lesson')->disableOriginalConstructor()->getMock();
        $inputParser = $this->getMock('\Nagoya\Util\InputParser');
        $lessonGenerator = $this->getMock('\Nagoya\LessonGenerator');
        $input = '1_12345';
        $expectedOutput = '1_1';

        $inputParser
            ->expects($this->once())
            ->method('convertToStaffs')
            ->with($this->equalTo($input))
            ->will($this->returnValue([$staff1]))
        ;
        $lessonGenerator
            ->expects($this->once())
            ->method('generate')
            ->with($this->equalTo([$staff1]))
            ->will($this->returnValue([$lesson1]))
        ;

        $englishClass = new EnglishClass($inputParser, $lessonGenerator);
        $output = $englishClass->run($input);

        // $this->assertEquals($expectedOutput, $output);
    }
}
