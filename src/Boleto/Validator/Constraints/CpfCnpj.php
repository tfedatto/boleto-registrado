<?php
/**
 * Created by PhpStorm.
 * User: tiago_fedatto
 * Date: 03/04/18
 * Time: 17:20
 */

namespace Boleto\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class CpfCnpj extends Constraint
{
    public $cpf = false;
    public $cnpj = false;
    public $mask = false;
    public $messageMask = 'O {{ type }} não está em um formato válido.';
    public $message = 'O {{ type }} informado é inválido.';
}