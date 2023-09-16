<?php
//TODO: Задание 4
// Создать класс, наследуемый от ParentClass и реализующий интерфейс InterfaceOne.
// Класс ParentClass и ****интерфейс InterfaceOne создавать не требуется.
// В созданном классе реализовать шаблон “одиночка”

use InterfaceOne;
use ParentClass;

class Singleton extends ParentClass implements InterfaceOne
{
    protected static mixed $instance;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    public static function getInstance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function doAction(): void
    {
        /* ... */
    }
}

Singleton::getInstance()->doAction();

//TODO: Задание 5
// Оптимизировать код:
/**
global $items;
var_export(test($items));
function test($items) {
    $sites = [];
    $result = [];
    foreach($items as $item) {
        preg_match('/(site1\.ru)/', $item->site, $matches);
        if ($matches) {
            $sites[count($sites)] = 'site1.ru';
        } else {
            $sites[count($sites)] = 'site2.ru';
        }

        if($result < count($sites)) {
            $result[count($result)] = count($sites);
        }
    }
    testTwo($result);
    return $sites;
}

function testTwo($arr) {
    $newArr = [];
    foreach($arr as $itemRes) {
        if($itemRes > 0) $newArr = $itemRes;
    }
}
 *
 */
global $items;
var_export(test($items));
function test($items)
{
    $sites = [];
    foreach($items as $item) {
        preg_match('/(site1\.ru)/', $item->site, $matches);
        if ($matches) {
            $sites[] = 'site1.ru'; // set new element
        } else {
            $sites[] = 'site2.ru'; // set new element
        }
    }
    return $sites;
}
