<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 17/02/2017
 * Time: 17:16
 */
namespace App\Http\Controllers\Api\Admin;

use App\Criteria\MensagemFinanceiroCriteria;
use App\Http\Controllers\BaseController;
use App\Http\Requests\MensagemFinanceiroRequest;
use App\Repositories\MensagemFinanceiroRepository;

class MensagemFinanceiroController extends BaseController
{
    /**
     * @var MensagemFinanceiroRepository
     */
    private $mensagemFinanceiroRepository;

    public function __construct(MensagemFinanceiroRepository $mensagemFinanceiroRepository)
    {
        parent::__construct($mensagemFinanceiroRepository, MensagemFinanceiroCriteria::class);
        $this->mensagemFinanceiroRepository = $mensagemFinanceiroRepository;
    }

    /**
     * @return array
     */
    public function getValidator($id = null)
    {
        $this->validator = (new MensagemFinanceiroRequest())->rules();
        return $this->validator;
    }
}
