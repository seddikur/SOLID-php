L - Liskov substitution Principle - принцип подстановки Барбары Лисков.
Должна быть возможность вместо базового (родительского) типа (класса) подставить любой его подтип (класс-наследник),
при этом работа программы не должна измениться.
Данный принцип непосредственно связан с наследованием классов

Пример, есть некий класс банковского счета, в нем содержаться три метода (баланса, пополнение, оплата)

<?php

class Account {
    public function balance(string $NumberAccount){
        // some logic;
    }
    public function refill(string $NumberAccount, int $Sum){
        // some logic;
    }
    public function payment(string $NumberAccount, int $Sum){
        // some logic;
    }
}

?>

Нам дают задача написать еще два класса - зарплатный счет и депозитный счет, оба счета наследуются от общего
родительского класса Account, но депозитный счет не должен содержать метода для оплаты payment

Реализация с нарушением принципа подстановки:

<?php

class SalaryAccount extends Account {
    public function balance(string $NumberAccount){
        // some logic;
    }
    public function refill(string $NumberAccount, int $Sum){
        // some logic;
    }
    public function payment(string $NumberAccount, int $Sum){
        // some logic;
    }
}

class DepositAccount extends Account {
    public function balance(string $NumberAccount){
        // some logic;
    }
    public function refill(string $NumberAccount, int $Sum){
        // some logic;
    }
    // Данный метод не поддерживается в этой реализации и мы пробрасываем исключение
    public function payment(string $NumberAccount, int $Sum){
        throw new Exception("Operation not supported");
    }
}

?>

В этом примере идет нарушение принципа подстаноки Лисков, если сейчас в программе мы заменим класс Account
на дочерний элемент SalaryAccount то все будет работать, так как класс SalaryAccount реализует все методы
родительского класса, однако если на его место мы подставим класс DepositAccount то программа будет работать некорректно!
Поскольку в классе DepositeAccount не поддерживается метод payment

Рассмотрим более правильную реализацию

<?php

class Account {
    public function balance(string $NumberAccount){
        // some logic;
    }
    public function refill(string $NumberAccount, int $Sum){
        // some logic;
    }
}

class DepositAccount extends Account {
    public function balance(string $NumberAccount){
        // some logic;
    }
    public function refill(string $NumberAccount, int $Sum){
        // some logic;
    }
}

class PaymentAccount extends Account {
    public function payment(string $NumberAccount, int $Sum){
        // payment logic
    }
}

class SalaryAccount extends PaymentAccount {
    public function balance(string $NumberAccount){
        // some logic;
    }
    public function refill(string $NumberAccount, int $Sum){
        // some logic;
    }
    public function payment(string $NumberAccount, int $Sum){
        // some logic;
    }
}

?>

Принцип подстановки Барбары Лисков заключается в правильном использовании отношения наследования.
Мы должны создавать наследников какого-либо базового класса тогда и только тогда,
когда они собираются правильно реализовать его логику, не вызывая проблем при замене родителей на наследников.