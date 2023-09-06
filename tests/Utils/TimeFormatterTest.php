<?php

namespace App\Tests\Utils;
use App\Utils\TimeFormatter;

use PHPUnit\Framework\TestCase;

/**
 * Clase que contiene pruebas para TimeFormatter.
 */
class TimeFormatterTest extends TestCase
{
    /**
     * Testea el método millisecondsToTimeString de TimeFormatter.
     */
    public function testMillisecondsToTimeString(): void
    {
        // Prueba con un valor de 0 milisegundos
        $milliseconds = 0;
        $expectedResult = '0s 0.000000ms';
        $result = TimeFormatter::millisecondsToTimeString($milliseconds);
        $this->assertEquals($expectedResult, $result);

        // Prueba con un valor de 12345 milisegundos
        $milliseconds = 12345;
        $expectedResult = '12s 345.000000ms';
        $result = TimeFormatter::millisecondsToTimeString($milliseconds);
        $this->assertEquals($expectedResult, $result);

        // Prueba con un valor de 99999 milisegundos
        $milliseconds = 99999;
        $expectedResult = '99s 999.000000ms';
        $result = TimeFormatter::millisecondsToTimeString($milliseconds);
        $this->assertEquals($expectedResult, $result);
    }
}
