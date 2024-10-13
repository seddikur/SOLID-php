O - Open closed Principle - принцип открытости-закрытости.
Классы должны быть открыты для расширения, но закрыты для изменения.

Программные сущности (классы, компоненты и т. д.) должны быть открыты для расширения, НО закрыты для изменения.
Реализовывать новый функционал следует за счет расширения, создания новых дочерних сущностей а не за счет изменения родительсикх

Пример на основе класса, который отправляет сообщение на email

<?php

class NatificationService {
    public function sendNatification(string $message){
        // Отправка сообщения на email
    }
}

?>

Предположим,
что нам нужно доработать функционал таким образом, чтобы сообщение отправлялось не только на eamil но и sms

<?php

class NatificationService2 {
    public function sendNatification(string $messageType, string $message){
        if($messageType === "email"){
            // Отправка сообщения на email
        }
        if($messageType === "sms"){
            // Отправка SMS сообщения
        }
    }
}
?>

В данном примере мы нарушаем принцип открытости-закрытости, так как изменяем текущий функционал
Для того чтобы придерживаться принципа открытости-закрытости нам необходимо спроектировать наш код таким образом,
чтобы каждый мог повторно использовать нашу функцию, просто расширив ее. Вынесем NotificationService в интерфейс, и будем расширять

<?php

interface NatificationServiceInterface {
    public function sendNatification(string $message): void;
}

class EmailNotification implements NatificationServiceInterface {
    public function sendNatification(string $message): void
    {
        // Отправка сообщения на email
    }
}

class SmsNotification implements NatificationServiceInterface {
    public function sendNatification(string $message): void
    {
        // Отправка SMS сообщения
    }
}