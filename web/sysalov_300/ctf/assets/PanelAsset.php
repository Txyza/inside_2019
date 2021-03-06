<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii;
use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class PanelAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
		'/css/bootstrap.min.css'
	];
    public $js = [];
    public $jsOptions = [
		'position' => View::POS_END
	];
    public $depends = [];
	
	public function init()
	{
		parent::init();
		
		if (YII_ENV && YII_ENV === 'dev') {
			$this->js[] = 'http://ctf.ru:8080/app.js';
			return;
		}
		
		$chunks = ['manifest', 'vendor', 'app'];
		
		$list = json_decode(file_get_contents(Yii::getAlias('@frontend') . '/assets.json'), true);
		foreach ($chunks AS $chunk) {
			if (empty($list[$chunk])) {
				continue;
			}
			foreach ($list[$chunk] AS $asset) {
				$e = pathinfo($asset, PATHINFO_EXTENSION);
				switch ($e) {
					case 'js':
						$this->js[pathinfo($asset, PATHINFO_FILENAME)] = '/assets/' . $asset;
						break;
					case 'css':
						$this->css[] = '/assets/' . $asset;
						break;
				}
			}
		}
	}
}
