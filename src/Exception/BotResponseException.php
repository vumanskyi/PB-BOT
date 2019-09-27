<?php
declare(strict_types=1);

namespace PB\Exception;
use Throwable;

/**
 * Exception class when something going wrong from bot response
 *
 * @author Vlad Umanskyi <vladumanskyi@gmail.com>
 */
class BotResponseException extends \Exception
{
    public function __construct(string $message = null, int $code = 0, Throwable $previous = null)
    {
        if ($message === null) {
            $message = 'Bad response from Bot';
        }

        parent::__construct($message, $code, $previous);
    }
}