<?php

namespace App\Telegram;

use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\Keyboard\ReplyButton;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;
use Illuminate\Support\Stringable;

class Handler extends WebhookHandler
{
    protected function handleUnknownCommand(Stringable $text): void
    {
        if ($text->value() === '/start') {
            $this->reply('Рады тебя видеть 👋');
            $this->home();
        } else {
            $this->reply('Непонимаю...');
        }
    }

    protected function handleChatMessage(Stringable $text): void
    {
        if ($text->value() === 'Чай 🫖') {
            $this->reply('Зелёный чай, чёрный чай');
        } elseif ($text->value() === 'Кофе ☕') {
            $this->reply('Арабика, Робуста');

        } elseif ($text->value() === 'Другое 🧉') {
            $this->reply('Другое');
            $this->other();
        } elseif ($text->value() === 'Главное меню 🏠') {
            $this->home();
        } elseif ($text->value() === 'Контакты 📞') {
            $this->reply('Тут Вам помогут 24/7:' . "\n" . '@timeiscreate');
        } else {
            $this->reply('К сожалению такого товара у нас нет...');
        }
    }

    public function home(): void
    {
        $this->chat->message('Главное меню 🏠')
            ->replyKeyboard(ReplyKeyboard::make()->buttons([
                ReplyButton::make('Чай 🫖'),
                ReplyButton::make('Кофе ☕'),
                ReplyButton::make('Другое 🧉'),
                ReplyButton::make('Контакты 📞'),
            ])->resize()->chunk(3))->send();
    }

    public function like(): void
    {
        Telegraph::message("Спасибо за лайк ❤️")->send();
    }

    public function subscribe(): void
    {
        Telegraph::message($this->data->get('sub'))->send();
    }

    public function other(): void
    {
        $this->chat->message('Здесь представлены необычные виды напитков и добавок, такие как "Василёк" или "Лаванда".')
            ->replyKeyboard(ReplyKeyboard::make()->buttons([
                ReplyButton::make('Какао 🥛'),
                ReplyButton::make('Premium 🥇'),
                ReplyButton::make('Добавки 🌼'),
                ReplyButton::make('Главное меню 🏠'),
            ])->resize()->chunk(3))->send();
    }

    public function help(): void
    {
        $this->reply('Пока что я умею только говорить:(');
    }
}
