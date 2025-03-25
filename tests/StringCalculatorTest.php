<?php

declare(strict_types=1);

namespace Deg540\StringCalculatorPHP\Test;

use Deg540\StringCalculatorPHP\StringCalculator;
use PHPUnit\Framework\TestCase;

final class StringCalculatorTest extends TestCase
{
    protected function setUp(): void{
        parent::setUp();

        $this->stringCalculator = new StringCalculator();
    }

    /**
     * @test
     */
    public function ifEntryNullOutputIsZero(): void{
        $result = $this->stringCalculator->add("");

        $this->assertEquals(0, $result);
    }

    /**
     * @test
     */
    public function ifInputOneStringNumberOutputThatIntNumber(): void{
        $result = $this->stringCalculator->add("1");

        $this->assertEquals(1, $result);
    }

    /**
     * @test
     */
    public function ifInputTwoStringNumberOutputItsSum(): void{
        $result = $this->stringCalculator->add("1,2");

        $this->assertEquals(3, $result);
    }

    /**
     * @test
     */
    public function givenNumbersSeparatedByCommasReturnResult(): void{
        $result = $this->stringCalculator->add("1,2,3,4,5,6,7,8,9");

        $this->assertEquals(45, $result);
    }

    /**
     * @test
     */
    public function givenLineBreakReturnItsSum(): void{
        $result = $this->stringCalculator->add("1\n2,3,4,5,6\n7,8,9");

        $this->assertEquals(45, $result);
    }

    /**
     * @test
     */
    public function givenNumbersSeparatedByCustomDelimiterReturnSumOFNumbers(): void
    {
        $this->assertEquals(3, $this->stringCalculator->add("//&\n1&2"));
    }


    /**
     * @test
     */
    public function givenDelimeterReturnItsSum(): void{
        $result = $this->stringCalculator->add("//:\n1\n2;3:4:5\n6\n7:8:9");

        $this->assertEquals(45, $result);
    }

    /**
     * @test
     */
    public function givenNegativeNumbersThrowsException(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("negativos no soportados: -2, -3");

        $this->stringCalculator->add("1,-2,-3,4");
    }

    /**
     * @test
     */
    public function givenNumberGreaterThan1000IsIgnored(): void
    {
        $result = $this->stringCalculator->add("2,1001");

        $this->assertEquals(2, $result);
    }

    /**
     * @test

    public function givenDelimiterWithDifferentLongitudeReturnsResult(): void
    {
        $result = $this->stringCalculator->add("//[***]\n123");

        $this->assertEquals(6, $result);
    }
    */

}