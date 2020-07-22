<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 8/28/2019
 * Time: 7:28 PM
 */

namespace App\Warnings;

use App\User;
use HugoJF\ModelWarnings\Contracts\Warning;

class AgreedToTerms extends Warning
{
    protected $enforcing;

    public function __construct(User $user)
    {
        parent::__construct($user);

        $this->enforcing = config('vip-admin.enforce-terms', false);
    }

    public function triggered()
    {
        return $this->enforcing && $this->context->terms !== true;
    }

    /**
     * @inheritDoc
     */
    public function buildMessage()
    {
        return [
            'message' => 'Você ainda não revisou e concordou com os termos!',
            'level'   => 'danger',
            'url'     => route('settings'),
        ];
    }
}
