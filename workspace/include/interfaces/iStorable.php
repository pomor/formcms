<?php
interface iStorable
{
	/**
	 * get Object name
	 */
	public function getName();

	/**
	 * get Namespace
	 * ('class' z.b.)
	 */
	public function getNamespace();
}
?>