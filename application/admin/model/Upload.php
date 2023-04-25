<?php
namespace app\admin\model;


vendor('qiniu/php-sdk.autoload');
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use think\Db;
use think\Model;
use think\Request;

/**
* 
*/
class Upload extends Model
{
    public $setting;
	function initialize()
	{
		parent::initialize();

		$this->setting=model('setting')->getSetting();


	}

	public function upfile($type,$filename = 'file',$is_water = false){

		// 获取表单上传文件 例如上传了001.jpg
		$file = request()->file($filename);


        //先检测MD5和哈希是否存储过
        $md5=$file->hash('md5');
        $sha1=$file->hash('sha1');
        $is_up=$this->checkFileIsUp($md5,$sha1,$this->setting['upload_type']);

        if($is_up !== true){
            //上传过了
            $is_up['code']=200;
            $is_up['msg']='上传成功';
            $is_up['info']['name']=$file->getInfo('name');
            return $is_up;
        }





        //type 2 七牛  3 oss  1 本地
        if($this->setting['upload_type'] == 2){
            //七牛云存储
            $tmp_name=$file->getInfo('tmp_name');   //临时目录
            //文件后缀
            $ext = pathinfo($file->getInfo('name'), PATHINFO_EXTENSION);
            $config = $this->setting['qiniu_config'];
            // 构建一个鉴权对象
            $auth =new Auth($config['accessKey'],$config['secretKey']);
            // 生成上传的token
            $token = $auth->uploadToken($config['bucket']);

            // 上传到七牛后保存的文件名
            $up_file_name=date('Ymd') . '/' . md5($tmp_name . time().mt_rand(0,9999));
            $key = $up_file_name . '.' .$ext;

            // 初始化UploadManager类
            $uploadMgr = new UploadManager();
            list($ret,$err) = $uploadMgr->putFile($token,$key,$tmp_name);
            if($err !== null){
                return array('code'=>0,'msg'=>$err);
            }else{

                $file_path=$config['domain'] . '/' . $key;

                //保存上传历史
                $arr=['file_size'=>$file->getInfo('size'),'create_time'=>time(),'filename'=>$file->getInfo('name'),'file_path'=>$file_path,'file_md5'=>$md5,'file_sha1'=>$sha1,'suffix'=>$file->getInfo('type'),'up_type'=>2];
                $this->saveUpload($arr);
                return array('code'=>200,'msg'=>'上传成功','path'=>$file_path,'savename'=>$up_file_name,'filename'=>$file->getInfo('name'),'info'=>$file->getInfo());

            }

        }else if ($this->setting['upload_type'] == 3){
            return array('code'=>0,'msg'=>'上传方式不存在');
        }else{
            // 移动到框架应用根目录/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads' . DS . $type);
            if($info){
                $path = DS . 'uploads' . DS . $type . DS .$info->getSaveName();
                //如果需要添加水印
                /*$setting = cache('settings');
                if($is_water && $setting['is_watermark'] && $setting['watermark'] && $type = 'images' ){
                    $image = \think\Image::open(ROOT_PATH . $path);
                    if($image->width() >= $setting['watermark_width'] && $image->height() >= $setting['watermark_height']){
                        $image->water(ROOT_PATH . $setting['watermark'],$setting['watermark_locate'],$setting['watermark_alpha'])->save(ROOT_PATH . $path);
                    }
                }*/
                $path=str_replace("\\","/",$path);

                //保存上传历史
                $arr=['file_size'=>$info->getSize(),'create_time'=>time(),'filename'=>$file->getInfo('name'),'file_path'=>$path,'file_md5'=>$md5,'file_sha1'=>$sha1,'suffix'=>$info->getType()];
                $this->saveUpload($arr);
                return array('code'=>200,'msg'=>'上传成功','path'=>$path,'savename'=>$info->getSaveName(),'filename'=>$info->getFilename(),'info'=>$info->getInfo());
            }else{
                return array('code'=>0,'msg'=>$file->getError());
            }
        }

	}

	public function upfiles($type,$filename = 'file',$is_water = false){
		// 获取表单上传文件 例如上传了001.jpg
		$files = request()->file($filename);


		$result = array('code'=>200,'msg'=>'',);
		foreach($files as $k => $file){
			// 移动到框架应用根目录/uploads/ 目录下

			$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads' . DS . $type);
			if($info){
				$path = DS . 'uploads' . DS . $type . DS .$info->getSaveName();
				//如果需要添加水印
				/*$setting = cache('settings');
				if($is_water && $setting['is_watermark'] && $setting['watermark'] && $type = 'images' ){
					$image = \think\Image::open(ROOT_PATH . $path);
					if($image->width() >= $setting['watermark_width'] && $image->height() >= $setting['watermark_height']){
						$image->water(ROOT_PATH . $setting['watermark'],$setting['watermark_locate'],$setting['watermark_alpha'])->save(ROOT_PATH . $path);
					}
				}*/
				$path=str_replace("\\","/",$path);
				$result['data'][$k] = array('code'=>200,'msg'=>'上传成功','path'=>$path,'savename'=>$info->getSaveName(),'filename'=>$info->getFilename(),'info'=>$info->getInfo());
			}else{
				$result['data'][$k] = array('code'=>0,'msg'=>$file->getError());
				$result['msg'] .= '第['.$k.']张'.$file->getError().' , ';
			}
		}
		if(empty($result['msg'])){
			$result['msg'] = '上传成功';
			$result['code'] = 200;
		}else{
			$result['msg'] = trim($result['msg'],',');
			$result['code'] = 100;
		}
		return $result;
	}

    //根据文件MD5和哈希值判断文件是否上传过
	public function checkFileIsUp($md5,$sha1,$type){
        $file_data=$this->where(['file_md5'=>$md5,'file_sha1'=>$sha1,'up_type'=>$type])->find();
        if(empty($file_data)){
            return true;
        }else{

            return ['path'=>$file_data['file_path'],'info'=>['name'=>$file_data['filename'],'size'=>$file_data['file_size'],'type'=>$file_data['suffix']]];
        }
    }
    public function saveUpload($arr){
        $this->insert($arr);
    }

}