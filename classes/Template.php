<?php

/**
 * Класс Template
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();
//error_reporting(0);

class Template {

    /**
     * @var string
     */
    protected $dir;

    /**
     * @var string
     */
    protected $ext;

    /**
     * @var string
     */
    protected $out;

    /**
     * @var array
     */
    protected $bloc = array();

    /**
     * @var array
     */
    protected $var = array();

    /**
     * @param $dir
     * @param $ext
     */
    public function __construct($dir, $ext) {
        $this->dir = $dir;
        $this->ext = $ext;
    }

    /**
     * @param string $file
     */
    public function main($file) {
        $this->out = file_get_contents($this->dir . $file . $this->ext);
    }

    /**
     * @return array
     */
    protected function getPatterns() {
        return array(
            '#%\s*function\s*(.*?)\s*%#',
            '#%\s*endfunction\s*%#',
            '#%\s*for\s*(.*?)\s*%#',
            '#%\s*endfor\s*%#',
            '#%\s*loop\s*(.*?)\s*%#',
            '#%\s*endloop\s*%#',
            '#%%\s*(.*?)\s*%%#',
            '#%\s*if\s*(.*?)\s*%#',
            '#%\s*elseif\s*(.*?)\s*%#',
            '#%\s*endif\s*%#',
            '#%\s*else\s*%#',
            '#%\s*php\s*(.*?)\s*%#',
        );
    }

    /**
     * @return array
     */
    protected function getReplace() {
        return array(
            '<?php function \\1{?>' . PHP_EOL,
            '<?php } ?>' . PHP_EOL,
            '<?php for \\1{?>' . PHP_EOL,
            '<?php } ?>' . PHP_EOL,
            '<?php foreach(\\1):?>' . PHP_EOL,
            '<?php endforeach;?>' . PHP_EOL,
            '<?php echo \\1;?>' . PHP_EOL,
            '<?php if(\\1):?>' . PHP_EOL,
            '<?php elseif(\\1):?>' . PHP_EOL,
            '<?php endif;?>' . PHP_EOL,
            '<?php else:?>' . PHP_EOL,
            '<?php \\1;?>' . PHP_EOL
        );
    }

    /**
     * @param string $source
     * @return string
     */
    protected function replace($source) {
        return preg_replace($this->getPatterns(), $this->getReplace(), $source);
    }

    /**
     * @param string $source
     * @param string $file
     * @param array $data
     * @return string
     */
    protected function compile($source, $file, $data = array()) {
        ob_start();
        if(!is_null(eval('?>' . $this->replace($source) . '<?php '))) {
            $error = error_get_last();
            echo $file . $this->ext . ':  ' . $error['message'] . ' line:' . $error['line'];
        }
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    /**
     * @param string $file
     * @return string
     */
    public function get($file) {
        return file_get_contents($this->dir . $file . $this->ext);
    }

    /**
     * @param string $bloc
     * @param string $file
     * @param array $data
     */
    public function bloc($bloc, $file, $data = array()) {
        if($file !== ''){
            $this->var[$bloc] = $this->compile($this->get($file), $file, $data);
        }else{
            $this->set($bloc, '');
        }
    }

    /**
     * @param string $file
     * @param array $data
     * @return string
     */
    public function compileBloc($file, $data = array()) {
        return $this->compile($this->get($file), $file, $data);
    }

    /**
     * @param string $str
     * @param array $data
     * @return string
     */
    public function compileStr($str, $data = array()) {
        return $this->compile($str, 'str', $data);
    }

    /**
     * @param string $find
     * @param string $replace
     */
    public function set($find, $replace) {
        $this->var[$find] = $replace;
    }

    /**
     *
     */
    public function out() {
        foreach($this->var as $find => $replace) {
            $this->out = str_replace($find, $replace, $this->out);
        }
        echo $this->out;
    }

}