<?php

namespace Deg540\StringCalculatorPHP;

class StringCalculator
{
    public function __construct()
    {
    }

    public function add(string $numbers): int
    {
        if ($this->isEmpty($numbers)) {
            return 0;
        }

        if ($this->isDelimeterDeclared($numbers[0])) {
            return $this->delimeterCleanedArray($numbers);
        }

        $numbersArray = $this->cleanArray($numbers, ",");

        if ($this->isOnlyOneNumber($numbersArray)) {
            return (int)$numbersArray[0];
        }

        return $this->getSum($numbersArray);
    }

    public function add2(string $numbers): int
    {
        if ($this->isEmpty($numbers)) {
            return 0;
        }

        $numbers = str_replace('\n', ',', $numbers);

        if (str_contains($numbers, '//')) {
            $delimiter = substr($numbers, 2, 1);
            $numbers = str_replace(['//' . $delimiter . ',', $delimiter], ['','.'], $numbers);

            return array_sum(explode(',', $numbers));
        }

        if (str_contains($numbers, ',')) {
            return array_sum(explode(',', $numbers));
        }

        return $numbers;
    }


    public function isEmpty(string $numbers): bool
    {
        return empty($numbers);
    }

    public function isOnlyOneNumber(array $numbersArray): bool
    {
        return count($numbersArray) === 1;
    }

    public function getSum(array $numbersArray): int
    {
        $sum = 0;
        $negativeNumbers = [];

        foreach ($numbersArray as $number) {
            $currentNumber = (int)$number;

            if ($currentNumber < 0) {
                $negativeNumbers[] = $currentNumber; // Agregamos al array
            }
            if($currentNumber < 1000){
                $sum += $currentNumber;
            }
        }

        if (!empty($negativeNumbers)) {
            throw new \InvalidArgumentException("negativos no soportados: " . implode(", ", $negativeNumbers));
        }

        return $sum;
    }

    public function cleanArray(string $numbers, string $delimiter): array
    {
        $numbers = str_replace("\n", $delimiter, $numbers);
        $numbers = str_replace(";", $delimiter, $numbers);
        return explode($delimiter, $numbers);
    }

    public function obtainDelimeter(string $input): array
    {
        // Dividimos la cadena de entrada en líneas
        $lines = explode("\n", $input);

        // Extraemos el delimitador de la primera línea, después de "//"
        $delimiter = substr($lines[0], 2, 1);  // Extrae el delimitador de "//[delimitador]"
        // El segundo valor será la línea con los números
        $numbers = implode("\n", array_slice($lines, 1));

        return [$delimiter, $numbers];
    }

    public function isDelimeterDeclared($numbers): bool
    {
        return $numbers === "/";
    }

    public function delimeterCleanedArray(string $numbers): mixed
    {
        list($delimiter, $numbers) = $this->obtainDelimeter($numbers);

        $numbersArray = $this->cleanArray($numbers, $delimiter);
        return $this->getSum($numbersArray);
    }
}