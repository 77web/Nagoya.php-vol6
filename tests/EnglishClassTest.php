<?php

namespace Nagoya;

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
        $inputParser = $this->getMock('\Nagoya\Util\InputParser');

        $englishClass = new EnglishClass($inputParser);
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
}
