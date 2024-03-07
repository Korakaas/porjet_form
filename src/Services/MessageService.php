<?php

namespace App\Services;

class MessageService
{
    public function displayMessage()
    {
        $message = [
            'Symfony 7 est super !',
            'Les services sont des classes PHP',
            'J\'ai faim'];

        $index = array_rand($message);
        return $message[$index];
    }
}
