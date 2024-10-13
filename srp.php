S - Single Responsibility Principle - принцип единственной ответственности.
Каждый класс должен иметь только одну зону ответственности.

1 класс = 1 задача || 1 компонент = 1 задача
(данный принцип пременим не только к классам, но и к компонентам в функиональном программированиии, да да !)

Каждый класс выполянет только одну возложенную на него функцию - плохой практикой считается,
когда один класс содержит в себе много разных метдов, задач,
например один и тот же класс обрабатывает полученные данные, затем сохраняет их в бд и в добавок логирует какую-либо информацию.
Такой подход является антипаттерном - God Object !!!

Пример нарушения данного принципа

<?php

class Profile {
    public function __construct(
        public string $id,
        public string $name,
        public string $lastname,
        public string $email
    )
    {
    }

    public function saveToDatabase(){
        // Сохранение в базу данных
    }

    public function sendMessageToEmail(){
        // Отправка сообщения на почту
    }

    public function logging(){
        // Вывод информации в лог
    }
}

?>

Исправим этот код в соответствии с принципом единой ответственности !

<?php

class Entity {
    public function __construct(
        public string $id,
        public string $name,
        public string $lastname,
        public string $email
    )
    {
    }
}

class ProfileRepository {
    public function saveToDatabase(Entity $profile){
        // Сохранение в БД
    }
}

class MailController {
    public function sendMessageToEmail(Entity $profile){
        // Отправка сообщения на почту
    }
}

class ProfileLogger {
    public function logging(){
        // Вывод информации в лог
    }
}
?>

Следующий пример

<?php

class DataFetcher {
    public function get(string $url){
        // GET - Request
    }
    public function post(string $url){
        // POST - Request
    }
    public function put(string $url){
        // PUT - Request
    }
    public function delete(string $url){
        // DELETE - Request
    }

    // Метод получения пользователя по id
    public function getUser(int $id){
        $this->get('http://www.coder.com/users/' . $id);
    }

    public function getPost(int $id){
        $this->get('http://www.coder.com/posts/' . $id);
    }

    public function getReview(int $id){
        $this->get('http://www.coder.com/reviews/' . $id);
    }
}

?>

Перепишем на более правильную реализацию

<?php

class HttpClient {
    public function get(string $url){
        // GET - Request
    }
    public function post(string $url){
        // POST - Request
    }
    public function put(string $url){
        // PUT - Request
    }
    public function delete(string $url){
        // DELETE - Request
    }
}

class UserService {

    public function __construct(
        public HttpClient $client
    )
    {}

    public function getUser(int $id){
        $this->client->get('http://www.coder.com/users/' . $id);
    }

    public function getAllUsers(){
        $this->client->get('http://www.coder.com/users');
    }
}

class PostService {

    public function __construct(
        public HttpClient $client
    )
    {}

    public function getPost(int $id){
        $this->client->get('http://www.coder.com/posts/' . $id);
    }
}

class ReviewsService {

    public function __construct(
        public HttpClient $client
    )
    {}

    public function getReviews(){
        $this->client->get('http://www.coder.com/reviews');
    }
}