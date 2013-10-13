<?php
/**
 * Created by JetBrains PhpStorm.
 * User: diarmuid
 * Date: 07/10/2013
 * Time: 22:32
 * To change this template use File | Settings | File Templates.
 */

class Media_model extends CI_Model {

    function get_media($folder) {
        $this->load->helper('file');
        return get_filenames($folder);
    }

    function resize_media($file, $width = 740) {

        $config = array(
            'image_library' => 'gd2',
            'source_image'	=> $file,
            'create_thumb' => TRUE,
            'maintain_ratio' => TRUE,
            'width'	 => 75,
            'master_dim' => 'width'
        );
        $this->load->library('image_lib', $config);

        $this->image_lib->resize();
    }

}