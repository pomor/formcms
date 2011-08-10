<?php

interface iEvent
{
	/**
	 * run events
	 *
	 * @return boolean false - stop processing
	 */
	public function run();

	/**
	 * main template name
	 *
	 * @return string or null
	 */
	public function getMainTemplate();

	/**
	 * user darf klass benutzen
	 *
	 * @return boolean
	 */
	public function hasAccess();

	/**
	 * get error event zur�ck
	 *
	 * @return iEvent object or null
	 */
	public function getErrorEvent();

	/**
	 * no ob_start()
	 *
	 * @return boolean
	 */
	public function isStream();



}

?>