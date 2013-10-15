<?php
/**
 * Created by JetBrains PhpStorm.
 * User: diarmuid
 * Date: 07/10/2013
 * Time: 22:32
 * To change this template use File | Settings | File Templates.
 */

class Media_model extends CI_Model {

    const WIDTH = 720;

    function get_media($folder) {
        $this->load->helper('file');

        $files = get_filenames($folder);

        $return = array();
        $url = parse_url(base_url());

        foreach ($files as $file) {

            // Only include the base image and exclude index.html
            if (substr(pathinfo($file, PATHINFO_FILENAME), -8) != 'original'
                AND substr(pathinfo($file, PATHINFO_FILENAME), -3) != '@2x'
                AND $file != 'index.html') {

                $return[] = array(
                    'filename' => $file,
                    'url' => "//" . $url['host'] . $url['path'] . "media/" . $file,
                    'mime' => get_mime_by_extension($file),
                    'extension' => pathinfo ($file, PATHINFO_EXTENSION),
                );


            }
        }

        return $return;
    }

    function resize($file, $width = self::WIDTH) {

        $path = pathinfo($file);
        $dims = getimagesize($file);

        // Risize if the image is too big
        if ($dims[0] > $width) {

            // Temporarily bump the memory allowance to allow image resizing
            $memory_limit = ini_get('memory_limit');
            ini_set('memory_limit', '324M');

            // Backup the original file
            copy($file, $path['dirname'] . '/' . $path['filename'] . '_original' . '.' . $path['extension']);

            $config = array(
                'source_image' => $file,
                'master_dim' => 'width',
                'width' => $width,
            );

            // Resize image to smaller version
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $this->image_lib->clear();

            // If the image is big enough generate a 2x retina version
            if ($dims[0] >= $width * 1.5) {
                $config = array(
                    'source_image' => $path['dirname'] . '/' . $path['filename'] . '_original' . '.' . $path['extension'],
                    'master_dim' => 'width',
                    'width' => $width * 2,
                    'new_image' => $path['dirname'] . '/' . $path['filename'] . '@2x' . '.' . $path['extension']
                );
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $this->image_lib->clear();

            }

            // return memory limit to normal
            ini_set('memory_limit', $memory_limit);

        }
    }

}