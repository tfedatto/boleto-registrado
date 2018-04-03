<?php
/**
 * Created by PhpStorm.
 * User: tiago_fedatto
 * Date: 03/04/18
 * Time: 11:21
 */

namespace Boleto\Banks\Itau;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Boleto\Validator\Constraints;


class Beneficiario
{

    private $cpf_cnpj_beneficiario;
    private $agencia_beneficiario;
    private $conta_beneficiario;
    private $digito_verificador_conta_beneficiario;

    /**
     * @return mixed
     */
    public function getCpfCnpjBeneficiario()
    {
        return $this->cpf_cnpj_beneficiario;
    }

    /**
     * @param mixed $cpf_cnpj_beneficiario
     * @return mixed
     */
    public function setCpfCnpjBeneficiario($cpf_cnpj_beneficiario)
    {
        $this->cpf_cnpj_beneficiario = $cpf_cnpj_beneficiario;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAgenciaBeneficiario()
    {
        return $this->agencia_beneficiario;
    }

    /**
     * @param mixed $agencia_beneficiario
     * @return mixed
     */
    public function setAgenciaBeneficiario($agencia_beneficiario)
    {
        $this->agencia_beneficiario = $agencia_beneficiario;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContaBeneficiario()
    {
        return $this->conta_beneficiario;
    }

    /**
     * @param mixed $conta_beneficiario
     * @return mixed
     */
    public function setContaBeneficiario($conta_beneficiario)
    {
        $this->conta_beneficiario = $conta_beneficiario;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDigitoVerificadorContaBeneficiario()
    {
        return $this->digito_verificador_conta_beneficiario;
    }

    /**
     * @param mixed $digito_verificador_conta_beneficiario
     * @return mixed
     */
    public function setDigitoVerificadorContaBeneficiario($digito_verificador_conta_beneficiario)
    {
        $this->digito_verificador_conta_beneficiario = $digito_verificador_conta_beneficiario;
        return $this;
    }

    public function getAll(){
        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $message = 'O valor não pode ser vazio';
        $notBlank = new Assert\NotBlank(array('message' => $message));
        $metadata->addPropertyConstraint('cpf_cnpj_beneficiario', $notBlank);
        $metadata->addPropertyConstraint('cpf_cnpj_beneficiario', new Constraints\CpfCnpj());
        $metadata->addPropertyConstraint('agencia_beneficiario', $notBlank);
        $metadata->addPropertyConstraint('conta_beneficiario', $notBlank);
        $metadata->addPropertyConstraint('digito_verificador_conta_beneficiario', $notBlank);
    }

}