- Dependency Inversion Principle - принцип инверсии зависимостей.
Модули верхнего уровня не должны зависеть от модулей нижнего уровня.
И те, и другие должны зависеть от абстракции.
Абстракции не должны зависеть от деталей. Детали должны зависеть от абстракций.

Несмотря на сложное название, и на первый взгляд, сложную формулировку принцип весьма простой - его суть сводится
к уменьшению связанности компонентов-классов между собой, и использовании абстракций т. е. интерфейсов

Давайте рассмотрим пример, есть класс магазина Shop и класс отвечающий за оплату по банковской карте CreditCardPayment
Как мы видим, в этом примере у нас высокая связянность двух классов разного уровня, если нам потребуется добавить
новые методы оплаты, то придется изменить очень много логики, в идеале эти классы не должны зависеть друг от друга -
они должны зависеть от абстракций

<?php

class CreditCardPayment {
    public function PayByCreditCard(){
        // transaction logic
    }
}

class Shop {

    public CreditCardPayment $payment;

    public function __construct(CreditCardPayment $payment)
    {
        $this->payment = $payment;
    }

    public function handlePayment(Object $order, int $amount){
        $this->payment->PayByCreditCard();
    }
}

?>

Давайте напишем более красивую реализацию :)

<?php

interface Payment {
    public function handlePayment(): void;
}

class CardPayment implements Payment {
    public function handlePayment(): void
    {
        // Bank card payment logic
    }
}

class CashPayment implements Payment {
    public function handlePayment(): void
    {
        // Cash payment logic
    }
}

class PhoneNumberPayment implements Payment {
    public function handlePayment(): void
    {
        // Phone number payment logic
    }
}

class Shop {
    private Payment $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function handlePayment(Object $order, int $amount){
        $this->payment->handlePayment();
    }
}