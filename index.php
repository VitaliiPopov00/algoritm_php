<?php

$numCount = 50; // количество чисел для сложения
$digitCount = 50; // количество знаков в каждом числе

// генерация массива с $numCount числами по $digitCount знаков
$numbers = [];
for ($i = 0; $i < $numCount; $i++) {
    $num = '';

    for ($j = 0; $j < $digitCount; $j++) {
        $num .= rand(0, 9);
    }

    $numbers[] = $num;
}

/**
 * 1 способ - использование встроенных функции php :)
 * 
 * @param array $numbers массив числовых строк
 * @return $result строка с результатом сложения чисел
 */
function sumBigNumWithPHPFunction(array $numbers): string
{
    $result = '0';

    foreach ($numbers as $num) {
        $result = bcadd($result, $num);
    }

    return $result;
}

/**
 * 2 способ - сложение через столбик(как в математике), путем сложения цифр
 * (полный результат формируется в конце выполнения функции, промежуточного значения сложения чисел нет)
 * 
 * @param array $numbers массив числовых строк
 * @return string строка с результатом сложения чисел
 */
function sumBigNumColumn(array $numbers): string
{
    $result = '';
    $temp = 0;

    // сложение $i цифры каждого числа
    for ($i = strlen($numbers[0]) - 1; $i > -1; $i--) {
        $digitSum = $temp;

        foreach ($numbers as $number) {
            $digitSum += $number[$i];
        }

        $result = (string) ($digitSum % 10) . $result; // добавляем последнюю цифру к результату
        $temp = floor($digitSum / 10); // запоминаем остаток, после добавления последней цифры
    }

    if ($temp > 0) {
        $result = (string) $temp . $result;
    }

    return $result;
}

/**
 * 3 способ - сложение разрядов каждого числа
 * (полный результат формируется в конце выполнения функции, промежуточное значение сложения чисел формируется во время 
 * выполнения функции)
 * 
 * @param array $numbers массив числовых строк
 * @return string строка с результатом сложения чисел
 */
function sumBigNumColumnTwo(array $numbers): string
{
    $maxLength = strlen($numbers[0]);
    $result = array_fill(0, $maxLength + 1, 0); // cоздаем массив из {$maxLength + 1} элемента, так как последний может быть переносом.

    // перебираем каждое число
    foreach ($numbers as $number) {
        for ($i = 0; $i < $maxLength; $i++) {
            // прибавляем значение текущего разряда к соответствующему разряду в результирующем массиве
            $result[$i] += (int) $number[$maxLength - 1 - $i];
            
            // если возникло переполнение разряда, переносим избыток в следующий разряд
            if ($result[$i] >= 10) {
                $result[$i + 1] += floor($result[$i] / 10);
                $result[$i] %= 10;
            }
        }
    }
    
    return implode('', array_reverse($result));
}

$resultOne = sumBigNumWithPHPFunction($numbers);
$resultTwo = sumBigNumColumn($numbers);
$resultThree = sumBigNumColumnTwo($numbers);
?>

<div>
    <?= "Результат 1 функции: $resultOne\n"; ?>
</div>
<div>
    <?= "Результат 2 функции: $resultTwo\n"; ?>
</div>
<div>
    <?= "Результат 3 функции: $resultThree\n"; ?>
</div>