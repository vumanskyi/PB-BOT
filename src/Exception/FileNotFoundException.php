<?php
namespace PB\Exception;

/**
 * Exception class thrown when a file couldn't be found.
 */
class FileNotFoundException extends \Exception
{
    /**
     * FileNotFoundException constructor.
     * @param string|null $message
     * @param int $code
     * @param \Exception|null $previous
     * @param string|null $path
     */
    public function __construct(string $message = null, int $code = 0, \Exception $previous = null, string $path)
    {
        if (null === $message) {
            $message = sprintf('File "%s" could not be found.', $path);
        }
        parent::__construct($message, $code, $previous);
    }
}