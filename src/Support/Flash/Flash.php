<?php

namespace Support\Flash;

use Illuminate\Contracts\Session\Session;

final class Flash
{
    public const MESSAGE_KEY = 'shop_flash_message';
    public const CLASS_KEY = 'shop_flash_class';

    public function __construct(protected Session $session)
    {
    }

    public function get(): ?FlashMessage
    {
        $message = $this->session->get(self::MESSAGE_KEY);

        if (!$message) {
            return null;
        }

        return new FlashMessage(
            $message,
            $this->session->get(self::CLASS_KEY, '')
        );
    }

    public function info(string $message): void
    {
        self::flash($message,'info');
    }

    public function alert(string $message): void
    {
        self::flash($message,'alert');
    }

    private function flash(string $message, string $type): void
    {
        $this->session->flash(self::MESSAGE_KEY, $message);
        $this->session->flash(self::CLASS_KEY, config("flash.$type", ''));
    }
}
