I -  Interface Segregation Principle - принцип разделения интерфейсов.
Данный принцип обозначает, что не нужно заставлять клиента (класс) реализовывать интерфейс,
который не имеет к нему отношения.

Предположим ситуацию, когда у нас есть интерфейс для класса, который реализует оплату несколькими возможными способами,
- банковской картой, через систему PayPal и по номеру мобильного телефона

<?php

interface Payments {
    public function payCreditCard(): void;
    public function payPayPal(): void;
    public function payPhoneNumber(): void;
}

?>

Далее при реализации самих классов-сервисов, которые будут реализовывать (имплементировать) контракт (интерфейс), мы
столкнемся с проблемой, допустим у нас будут два класса - InternetPayment и TerminalPayment, первый класс будет реализовывать
все методы интерфейса а во втором будет отсутствовать метод оплаты по номеру телефона, таким образом, если оба эти класса
имплементируют один и тот же интерфейс, то мы по сути, заставляем класс TermialPayment реализовывать метод, который ему не нужен


<?php

class InternetPayment implements Payments {
    public function payCreditCard(): void
    {
        // логика оплаты банковской картой
    }

    public function payPayPal(): void
    {
        // логика оплаты через PayPal
    }

    public function payPhoneNumber(): void
    {
        // логика оплаты по номеру телефона
    }
}

class TerminalPayment implements Payments {
    public function payCreditCard(): void
    {
        // логика оплаты банковской картой
    }

    public function payPayPal(): void
    {
        // логика оплаты через PayPal
    }

    // Мы вынуждены реализовать метод, который не нужен этому классу
    public function payPhoneNumber(): void
    {
        // ???????????????
    }
}
?>

Именно так выглядит нарушение принципа разделения интерфейсов !

Напишем более правильную реализацию, поскольку мы помним, что класс может имплементировать не один а сразу несколько
интерфейсов, мы разделим интерфейс Payments на несклько более маленьких интерфейсов и напишем более гибкую структуру

<?php

interface CreditCardPayment {
    public function payCreditCard(): void;
}

interface PayPalPayment {
    public function payPayPal(): void;
}

interface PhoneNumberPayment {
    public function payPhoneNumber(): void;
}

class InternetPaymentService implements CreditCardPayment, PayPalPayment, PhoneNumberPayment {
    public function payCreditCard(): void
    {
        // логика оплаты банковской картой
    }

    public function payPayPal(): void
    {
        // логика оплаты через PayPal
    }

    public function payPhoneNumber(): void
    {
        // логика оплаты по номеру телефона
    }
}

class TerminalPaymentService implements CreditCardPayment, PayPalPayment {
    public function payCreditCard(): void
    {
        // логика оплаты банковской картой
    }

    public function payPayPal(): void
    {
        // логика оплаты через PayPal
    }
}