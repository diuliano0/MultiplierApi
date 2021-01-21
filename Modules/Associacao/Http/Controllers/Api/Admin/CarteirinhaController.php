<?php

namespace Modules\Associacao\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Modules\Associacao\Criteria\CarteirinhaCriteria;
use Modules\Associacao\Http\Requests\DependenteRequest;
use Modules\Associacao\Services\CarteirinhaService;
use Modules\Associacao\Http\Requests\CarteirinhaRequest;
use Modules\Core\Services\ImageUploadService;
use App\Http\Controllers\BaseController;
use App\Interfaces\ICustomController;

class CarteirinhaController extends BaseController implements ICustomController
{

	/**
	 * @var  CarteirinhaCriteria
	 */
	private $carteirinhaCriteria;

	/**
	 * @var  CarteirinhaService
	 */
	private $carteirinhaService;

	/**
	 * @var ImageUploadService
	 */
	private $imageUploadService;

	public function __construct(
		CarteirinhaService $carteirinhaService,
		CarteirinhaCriteria $carteirinhaCriteria,
		ImageUploadService $imageUploadService)
	{
		parent::__construct($carteirinhaService->getDefaultRepository(), $carteirinhaCriteria);
		$this->carteirinhaCriteria = $carteirinhaCriteria;
		$this->carteirinhaService = $carteirinhaService;
		$this->imageUploadService = $imageUploadService;
	}

	public function getValidator()
	{
		return new CarteirinhaRequest();
	}

	public function index(Request $request)
	{
        return $this->carteirinhaService->atualizarTodas();
	}

	public function store(CarteirinhaRequest $request)
	{
		return $this->carteirinhaService->create($request->getOnlyDataFields());
	}

	public function gerarCarteirinha($id, CarteirinhaRequest $request){
		return $this->carteirinhaService->gerar($id, $request->getOnlyDataFields());
	}

	public function update(CarteirinhaRequest $request, $id)
	{
		return $this->carteirinhaService->update($request->getOnlyDataFields(), $id);
	}
}

