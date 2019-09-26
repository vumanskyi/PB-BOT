<?php
namespace PB\Config;

use OutOfBoundsException;
use PB\Exception\FileNotFoundException;
use Symfony\Component\Yaml\Yaml;

class YmlConfig implements ConfigInterface
{
    /**
     * @var string
     */
    protected $source = '';

    /**
     * @var array
     */
    protected $data = [];

    /**
     * YmlConfig constructor.
     * @throws FileNotFoundException
     */
    public function __construct()
    {
        $this->source = CONFIG . '/fields.yml';
        if (!file_exists($this->source)) {
            throw new FileNotFoundException('File not found ' . $this->source);
        }

        $data = Yaml::parseFile($this->source) ?? [];

        if (empty($data['fields'])) {
            throw new OutOfBoundsException('The filed "fileds" doesn\'t found');
        }

        $this->data = $data['fields'];
    }

    /**
     * @return string
     */
    public function source(): string
    {
        return $this->source;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return $this->data;
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset): bool
    {
        return isset($this->data[$offset]);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
}