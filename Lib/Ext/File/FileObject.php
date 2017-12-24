<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/25/2017
 * Time: 17:26
 */
namespace Here\Lib\Ext\File;


/**
 * Class FileObject
 * @package File
 */
class FileObject {
    /**
     * @var string
     */
    private $_file_path;

    /**
     * @var int
     */
    private $_mode;

    /**
     * @var array
     */
    private $_buffer;

    /**
     * @var int
     */
    private $_current_line;

    /**
     * FileObject constructor.
     * @param string $path
     * @param FileOpenMode|null $mode
     * @throws FileNotFound
     */
    final public function __construct(string $path, ?FileOpenMode $mode = null) {
        $abs_path = realpath($path);
        if ($abs_path === false) {
            throw new FileNotFound("file `{$path}` not found");
        }

        $this->_file_path = $abs_path;
        $this->_mode = $mode === null ? new FileOpenMode() : $mode;

        $this->_current_line = 0;
    }

    /**
     * @return string
     */
    final public function read_line(): string {
        if ($this->_buffer === null) {
            $this->_buffer = array();

            $fp = fopen($this->_file_path, 'r');
            while (!feof($fp)) {
                $this->_buffer[] = fgets($fp);
            }
            fclose($fp);
        }

        return $this->_buffer[$this->_current_line++];
    }

    /**
     * @return array
     */
    final public function read_lines(): array {
        return $this->_buffer;
    }

    /**
     * @param int $line_number
     * @return bool
     */
    final public function seek(int $line_number): bool {
        if ($line_number < 0 || $line_number > count($this->_buffer)) {
            return false;
        }

        $this->_current_line = $line_number - 1;
        return true;
    }

    /**
     * @return bool
     */
    final public function reset(): bool {
        return $this->seek(0);
    }
}
