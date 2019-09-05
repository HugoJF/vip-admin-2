<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 9/5/2019
 * Time: 12:20 AM
 */

namespace App\Services\Forms;

use Kris\LaravelFormBuilder\FormBuilder;

class ServiceForms
{
	protected $builder;

	public function __construct()
	{
		$this->builder = app(FormBuilder::class);
	}
}