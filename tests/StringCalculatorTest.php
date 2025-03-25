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
        $result = $this->stringCalculator->Add("");

        $this->assertEquals(0, $result);
    }
    /**
     * @test
     */
    public function ifInputOneStringNumberOutputThatIntNumber(): void{
        $result = $this->stringCalculator->Add("1");

        $this->assertEquals(1, $result);
    }
    /**
     * @test
     */
    public function ifInputTwoStringNumberOutputItsSum(): void{
        $result = $this->stringCalculator->Add("1,2");

        $this->assertEquals(3, $result);
    }
    /**
     * @test
     */
    public function givenMultipleNumbersReturnItsSum(): void{
        $result = $this->stringCalculator->Add("1,2,3,4,5,6,7,8,9");

        $this->assertEquals(45, $result);
    }

    /**
     * @test
     */
    public function givenLineBreakReturnItsSum(): void{
        $result = $this->stringCalculator->Add("1\n2,3,4,5,6\n7,8,9");

        $this->assertEquals(45, $result);
    }

    /**
     * @test
     */
    public function givenDelimeterReturnItsSum(): void{
        $result = $this->stringCalculator->Add("//:\n1\n2:3:4:5\n6\n7:8:9");

        $this->assertEquals(45, $result);
    }

    /**
     * @test
     */
    public function givenNegativeNumbersThrowException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("negativos no soportados: -2, -3");

        $this->stringCalculator->Add("1,-2,-3,4");
    }

    /**
     * @test
     */
    public function givenNumberGreaterThan1000IgnoreThatNumber(): void
    {
        $result = $this->stringCalculator->Add("//:\n1\n2:3000:9");

        $this->assertEquals(12, $result);
    }
}