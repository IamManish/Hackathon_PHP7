<?php
class Hackathon_PHP7_Model_Core_Resource_Session extends Mage_Core_Model_Resource_Session
{
    /**
     * Fetch session data
     *
     * @param string $sessId
     * @return string
     */
    public function read($sessId)
    {
        $select = $this->_read->select()
            ->from($this->_sessionTable, array('session_data'))
            ->where('session_id = :session_id')
            ->where('session_expires > :session_expires');
        $bind = array(
            'session_id'      => $sessId,
            'session_expires' => Varien_Date::toTimestamp(true)
        );

        $data = $this->_read->fetchOne($select, $bind);

        return (string)$data;

    }
}
		