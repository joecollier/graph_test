<?php
    namespace Editor\Helpers;
    require "vendor/autoload.php";

    class Validator {
        protected $min_dimension = 1;
        protected $max_dimension = 250;

        protected function isValidDimension($value)
        {
            return (!($value < $this->min_dimension || $value > $this->max_dimension));
        }

        public function isValidDimensions($x, $y)
        {
            if ($this->isValidDimension($x) && $this->isValidDimension($y)) {
                return true;
            } else {
                return
                    "Dimensions must be between {$this->min_dimension} and " .
                    "{$this->max_dimension}\n";
            }
        }
    }
?>