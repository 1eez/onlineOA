<?php
class flowClassAction extends runtAction
{
	public function pipeiAction()
	{
		m('flow')->repipei();
		echo 'success';
	}
}