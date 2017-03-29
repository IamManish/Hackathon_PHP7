<?php
class Hackathon_PHP7_Model_Core_Layout extends Mage_Core_Model_Layout
{
    /**
     * Get all blocks marked for output
     *
     * @return string
     */
    public function getOutput()
    {
        $out = '';
        if (!empty($this->_output)) {
            foreach ($this->_output as $callback) {
                $out .= $this->getBlock($callback[0])->{$callback[1]}();
            }
        }

        return $out;
    }
}
		