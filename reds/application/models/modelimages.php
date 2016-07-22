<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of images
 *
 * @author Doni
 */
class modelimages extends CI_Model{
    //put your code here
    public function resize($filename, $width, $height) {
		if (!file_exists('images/' . $filename) || !is_file('images/' . $filename)) {
			return;
		} 
		
		$info = pathinfo($filename);
		
		$extension = $info['extension'];
		
		$old_image = $filename;
		$new_image = 'cache/' . substr($filename, 0, strpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;
		
		if (!file_exists('images/' . $new_image) || (filemtime('images/' . $old_image) > filemtime('images/' . $new_image))) {
			$path = '';
			
			$directories = explode('/', dirname(str_replace('../', '', $new_image)));
			
			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;
				
				if (!file_exists('images/' . $path)) {
					@mkdir('images/' . $path, 0777);
				}		
			}
			
			$image = new Image('images/' . $old_image);
			$image->resize($width, $height);
			$image->save('images/' . $new_image);
		}
	
//		if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
//			return 'images/' . $new_image;
//		} else {
			echo base_url().'images/' . $new_image;
//		}	
	}
        
}
