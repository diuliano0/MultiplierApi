<?php

namespace App\Services;


class BaseService
{
	protected static function transformerData($data, $classPresenter){
		return transformer_data($data, $classPresenter);
	}

	protected function createAnexo(&$model, &$data, $diretorio, $base64 = true)
	{
		if(!key_exists('anexo', $data))
			throw new \Exception('a chave anexo não está presente no array');

		/** @var \Modules\Core\Services\ImageUploadService $imageUploadService */
		$imageUploadService = app(\Modules\Core\Services\ImageUploadService::class);
		$anexo = $data['anexo'];
		if($base64){
            if (isset($anexo['conteudo']) && !is_null($anexo['conteudo'])){
                $imageUploadService->upload64('conteudo', $diretorio, $anexo);
                $extensao = explode('.',$anexo['conteudo']);
                $anexo['extensao'] = $extensao[1];
                $data['anexo'] = $anexo;
            }
		}else{
			if (isset($anexo['conteudo']) && !is_null($anexo['conteudo'])){
				$anexo['extensao'] = $anexo['conteudo']->getClientMimeType();
				$imageUploadService->upload('conteudo', $diretorio, $anexo);
				$data['anexo'] = $anexo;
			}
		}

		$insertAnexo = function ($model, $diretorio, $anexo, &$data){
			try{
				$anexo = $model->anexo()->create([
					'diretorio' => $diretorio,
					'nome' => $anexo['conteudo'],
					'alias' => isset($anexo['alias'])?$anexo['alias']:$anexo['conteudo'],
					'extensao' => $anexo['extensao'],
				]);
				$data['anexo']['id'] = $anexo->id;
			}catch (\Exception $e){
				throw new \Exception($e->getMessage());
			}
		};

		if ($model->anexo() instanceof \Illuminate\Database\Eloquent\Relations\MorphMany) {
			$insertAnexo($model, $diretorio, $anexo, $data);
			return;
		}
		if (is_null($model->anexo)) {
			$insertAnexo($model, $diretorio, $anexo, $data);
			return;
		}
		if (isset($anexo['conteudo']) && !is_null($anexo['conteudo'])){
			$data['anexo']['id'] = $model->anexo->id;
			$model->anexo->fill([
				'diretorio' => $diretorio,
				'alias' => isset($anexo['alias'])?$anexo['alias']:$anexo['conteudo'],
				'nome' => $anexo['conteudo'],
				'extensao' => $anexo['extensao'],
			])->save();
		}
	}
	protected function addAnexo(&$model, &$data, $diretorio, $base64 = true)
	{
		if(!key_exists('anexo', $data))
			throw new \Exception('a chave anexo não está presente no array');

		/** @var \Modules\Core\Services\ImageUploadService $imageUploadService */
		$imageUploadService = app(\Modules\Core\Services\ImageUploadService::class);
		$anexo = $data['anexo'];
		if($base64){
            if (isset($anexo['conteudo']) && !is_null($anexo['conteudo'])){
                $imageUploadService->upload64('conteudo', $diretorio, $anexo);
                $extensao = explode('.',$anexo['conteudo']);
                $anexo['extensao'] = $extensao[1];
                $data['anexo'] = $anexo;
            }
		}else{
			if (isset($anexo['conteudo']) && !is_null($anexo['conteudo'])){
				$anexo['extensao'] = $anexo['conteudo']->getClientMimeType();
				$imageUploadService->upload('conteudo', $diretorio, $anexo);
				$data['anexo'] = $anexo;
			}
		}

		$insertAnexo = function ($model, $diretorio, $anexo, &$data){
			try{
				$anexo = $model->anexos()->create([
					'diretorio' => $diretorio,
					'nome' => $anexo['conteudo'],
					'alias' => isset($anexo['alias'])?$anexo['alias']:$anexo['conteudo'],
					'extensao' => $anexo['extensao'],
				]);
				$data['anexo']['id'] = $anexo->id;
			}catch (\Exception $e){
				throw new \Exception($e->getMessage());
			}
		};

		if ($model->anexos() instanceof \Illuminate\Database\Eloquent\Relations\MorphMany) {
			$insertAnexo($model, $diretorio, $anexo, $data);
			return;
		}
		if (is_null($model->anexo)) {
			$insertAnexo($model, $diretorio, $anexo, $data);
			return;
		}
		if (isset($anexo['conteudo']) && !is_null($anexo['conteudo'])){
			$data['anexo']['id'] = $model->anexo->id;
			$model->anexo->fill([
				'diretorio' => $diretorio,
				'alias' => isset($anexo['alias'])?$anexo['alias']:$anexo['conteudo'],
				'nome' => $anexo['conteudo'],
				'extensao' => $anexo['extensao'],
			])->save();
		}
	}
}
