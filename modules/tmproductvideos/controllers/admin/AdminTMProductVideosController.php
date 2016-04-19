<?php

class AdminTMProductVideosController extends ModuleAdminController
{
	public function ajaxProcessUpdatePosition()
	{
		$items = Tools::getValue('item');
		$total = count($items);
		$id_lang = Tools::getValue('id_lang');
		$success = true;
		for ($i = 1; $i <= $total; $i++)
			$success &= Db::getInstance()->update(
				'product_video_lang',
					array('sort_order' => $i),
					'`id_video` = '.preg_replace('/(video_)([0-9]+)/', '${2}', $items[$i - 1]).'
					AND `id_lang` ='.$id_lang
				);
		if (!$success)
			die(Tools::jsonEncode(array('error' => 'Position Update Fail')));
		die(Tools::jsonEncode(array('success' => 'Position Updated Success !', 'error' => false)));
	}

	public function ajaxProcessUpdateStatus()
	{
		$id_video = Tools::getValue('id_video');
		$id_lang = Tools::getValue('id_lang');
		$video_status = Tools::getValue('video_status');
		$success = true;
		if ($video_status == 1)
			$video_status = 0;
		else
			$video_status = 1;

		$success &= Db::getInstance()->update(
			'product_video_lang',
				array('status'=> $video_status),
				' id_video = '.$id_video.'
				AND id_lang = '.$id_lang
		);

		if (!$success)
			die(Tools::jsonEncode(array('error_status' => 'Status Update Fail')));
		die(Tools::jsonEncode(array('success_status' => 'Status Update Success!', 'error' => false)));
	}

	public function ajaxProcessUpdateItem()
	{
		$id_video = Tools::getValue('id_video');
		$id_lang = Tools::getValue('id_lang');
		$video_name = Tools::getValue('video_name');
		$video_description = Tools::getValue('video_description');
		$success = true;

		$success &= Db::getInstance()->update(
			'product_video_lang',
				array('name'=> $video_name, 'description'=> $video_description),
				' id_video = '.$id_video.'
				AND id_lang = '.$id_lang
		);

		if (!$success)
			die(Tools::jsonEncode(array('error_status' => 'Information Update Fail')));
		die(Tools::jsonEncode(array('success_status' => 'Information Update Success!', 'error' => false)));
	}

	public function ajaxProcessRemoveItem()
	{
		$id_video = Tools::getValue('id_video');
		$id_lang = Tools::getValue('id_lang');
		$success = true;

		$success &= Db::getInstance()->execute('DELETE FROM '._DB_PREFIX_.'product_video_lang WHERE id_video = '.$id_video.' AND id_lang = '.$id_lang);

		$any_video = Db::getInstance()->executeS('SELECT * FROM '._DB_PREFIX_.'product_video_lang WHERE id_video = '.$id_video);

		if (!$any_video)
			$success &= Db::getInstance()->execute('DELETE FROM '._DB_PREFIX_.'product_video WHERE id_video = '.$id_video);

		if (!$success)
			die(Tools::jsonEncode(array('error_status' => 'Removing Fail')));
		die(Tools::jsonEncode(array('success_status' => 'Video removed success!', 'error' => false)));
	}
}
