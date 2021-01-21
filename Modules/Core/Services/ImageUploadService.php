<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 12/01/2017
 * Time: 10:52
 */

namespace Modules\Core\Services;


use Illuminate\Http\Request;
use App\Services\BaseStorageService;
use Symfony\Component\Routing\Exception\InvalidParameterException;

class ImageUploadService
{
	/**
	 * @var Request
	 */
	private $request;
	/**
	 * @var BaseStorageService
	 */
	private $baseStorageService;

	public function __construct(
		Request $request,
		BaseStorageService $baseStorageService)
	{
		$this->request = $request;
		$this->baseStorageService = $baseStorageService;
	}

	public function upload($field, $path, &$data)
	{
		$request = &$data;
		/** @var UploadedFile $file */
		$file = $data[$field];
		if ($this->request->hasFile($field)) {
			if (!$file->isValid()) {
				Throw new InvalidParameterException('Ocorreu um erro ao realizar o upload');
			}
			$filename = md5(time().uniqid(rand(), true)) . '.' . $file->getClientOriginalExtension();
			$file->move(public_path($path), $filename);
			$request[$field] = $filename;
		}
		return null;
	}

	public function upload64($field, $path, &$data){
		$request = &$data;
		$temp = explode( ',', $request[$field] );
		$match = [];
		$temp[0] = preg_match('/data\:([A-Za-z0-9_-]*)\/([A-Za-z0-9_-]*)\;base64/i',$temp[0],$match);

		if(!$temp[0]){
			throw new \Exception('item não é um base64');
		}

		$filename = md5(time().uniqid(rand(), true)) . '.'.$match[2];
		//$file = base64_decode($temp[1]);
		/*$dive_file = $this->baseStorageService->getDefaultDriver();
		if($dive_file == 'local')
			$path = 'public/'.$path;

		$this->baseStorageService->disk()->put($this->baseStorageService->disk()->put($path.'/'.$filename, $file););*/
		//public_path()
		file_put_contents(public_path().'/'.$path.'/'.$filename, base64_decode($temp[1]));
		//$arquivo = $this->base64_to_jpeg($file, $path.'/'.$filename);
		$request[$field] = $filename;
		return null;
	}

	private function base64_to_jpeg($base64_string, $output_file) {
		$ifp = fopen( $output_file, 'wb' );
		$data = explode( ',', $base64_string );
		fwrite( $ifp, base64_decode( $data[ 1 ] ) );
		fclose( $ifp );
		return $output_file;
	}

	public function upload_me($field, $path, $data)
	{
		$request = &$data;
		$file = $data[$field];
		if ($this->request->hasFile($field)) {
			if (!$file->isValid()) {
				Throw new InvalidParameterException('Ocorreu um erro ao realizar o upload');
			}
			$filename = md5(time()) . '.' . $file->getClientOriginalExtension();
			$file->move($path, $filename);
			$request['imagem'] = $filename;
			return $request;
		}
		return null;
	}

	public function cropPhoto($path, $options, $target)
	{
		return \Image::make($path, $options)->save($target);
	}
}
