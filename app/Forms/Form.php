<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 9/15/2019
 * Time: 1:16 AM
 */

namespace App\Forms;

use Kris\LaravelFormBuilder\Form as BaseForm;

class Form extends BaseForm
{
	protected function buildHelpBlock($text)
	{
		return [
			'text' => $text,
			'tag' => 'small',
		];
	}
}