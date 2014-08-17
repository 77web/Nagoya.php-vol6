<?php

namespace Nagoya;

use Nagoya\Util\InputParser;
use Nagoya\Util\OutputFormatter;

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
        $lessonGenerator = new LessonGenerator([1, 2, 3, 4, 5], 4);
        $outputFormatter = new OutputFormatter();

        $englishClass = new EnglishClass($inputParser, $lessonGenerator, $outputFormatter);
        $output = $englishClass->run($input);

        $this->assertEquals($expectedOutput, $output);
    }

    /**
     * @return array
     */
    public function provideInputAndOutput()
    {
        return [
            ['1_12345', '1_1'],
            ['30_32451', '3_30'],
            ['1_12345|2_12345', '1_1:2'],
            ['3_12345|2_12345|1_12345', '1_1:2:3'],
            ['1_23415|2_12435|3_42135', '1_2|2_1|4_3'],
            ['1_23415|2_12435|3_42135|4_31245|5_53124', '1_2|2_1|3_4|4_3|5_5'],
            ['40_12345|21_12345|3_12345|61_12345|10_12345', '1_3:21:40:61|2_10'],
            ['1_23415|2_12435|3_42135|4_54321|5_12345|6_13524|7_42351|8_31254|9_24513|10_12345', '1_2:5:6:10|2_1:9|3_8|4_3:7|5_4'],
            ['1_54321|2_54321|3_54321|4_54321|5_54321|6_54321|7_54321|8_54321|9_54321|10_54321|11_54321|12_54321|13_54321|14_54321|15_54321|16_54321|17_54321|18_54321|19_54321|20_54321|21_54321', '1_17:18:19:20|2_13:14:15:16|3_9:10:11:12|4_5:6:7:8|5_1:2:3:4'],
            ['1_34152|2_23514|3_41325|4_15342|5_45312|6_35124|7_21453|8_52431|9_13245|10_54123|11_13245', '1_4:9:11|2_2:7|3_1:6|4_3:5|5_8:10'],
            ['92_41532|58_14325|40_25413|5_45132|71_35124|23_13452|60_35241|77_31542|53_13542|72_12354', '1_23:53:58:72|2_40|3_60:71:77|4_5:92'],

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
        $lessonGenerator = $this->getMockBuilder('\Nagoya\LessonGenerator')->disableOriginalConstructor()->getMock();
        $outputFormatter = $this->getMock('\Nagoya\Util\OutputFormatter');
        $input = '1_12345';
        $output = $expectedOutput = '1_1';

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
        $outputFormatter
            ->expects($this->once())
            ->method('format')
            ->with($this->equalTo([$lesson1]))
            ->will($this->returnValue($output))
        ;

        $englishClass = new EnglishClass($inputParser, $lessonGenerator, $outputFormatter);
        $output = $englishClass->run($input);

        $this->assertEquals($expectedOutput, $output);
    }
}
