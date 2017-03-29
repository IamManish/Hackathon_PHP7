<?php
class Hackathon_PHP7_Model_Core_File_Uploader extends Mage_Core_Model_File_Uploader
{
    /**
     * Validate file before save
     *
     * @access public
     */
    protected function _validateFile()
    {
        if ($this->_fileExists === false) {
            return;
        }

        //is file extension allowed
        if (!$this->checkAllowedExtension($this->getFileExtension())) {
            throw new Exception('Disallowed file type.');
        }
        //run validate callbacks
        foreach ($this->_validateCallbacks as $params) {
            if (is_object($params['object']) && method_exists($params['object'], $params['method'])) {
                $params['object']->{$params['method']}($this->_file['tmp_name']);
            }
        }
    }
}
		