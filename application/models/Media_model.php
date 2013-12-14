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

        $files = get_dir_file_info($folder, TRUE);

        $return = array();
        $url = parse_url(base_url());

        foreach ($files as $file) {

            // Only include the base image and exclude index.html
            if (substr(pathinfo($file['name'], PATHINFO_FILENAME), -8) != 'original'
                AND substr(pathinfo($file['name'], PATHINFO_FILENAME), -3) != '@2x'
                AND $file['name'] != 'index.html') {

                $return[] = array(
                    'filename' => $file['name'],
                    'url' => "//" . $url['host'] . $url['path'] . "media/" . $file['name'],
                    'mime' => get_mime_by_extension($file['name']),
                    'extension' => pathinfo ($file['name'], PATHINFO_EXTENSION),
                    'path' => $file['server_path'],
                    'date' => $file['date'],
                    'size' => $file['size']
                );
            }
        }

        // Find the original and 2x version if it exists
        foreach ($return as $key => $file) {
            $original = pathinfo($file['filename'], PATHINFO_FILENAME) . '_original.' . pathinfo($file['filename'], PATHINFO_EXTENSION);
            $zoom = pathinfo($file['filename'], PATHINFO_FILENAME) . '@2x.' . pathinfo($file['filename'], PATHINFO_EXTENSION);

            if (in_array($original, $files)) {
                $return[$key]['original'] = $original;
            }

            if (in_array($zoom, $files)) {
                $return[$key]['2x'] = $zoom;
            }

        }

        // Sort by modified date (newest first)
        usort($return, function($a, $b) {
                return $b['date'] - $a['date'];
            });

        return $return;
    }

    function resize($file, $width = self::WIDTH) {

        $dims = getimagesize($file);

        // Risize if the image is too big
        if ($dims[0] > $width) {

            // Temporarily bump the memory allowance to allow image resizing
            $memory_limit = ini_get('memory_limit');
            ini_set('memory_limit', '324M');

            // Backup the original file
            copy($file, $this->append_identifier($file, '_original'));

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
                    'source_image' =>  $this->append_identifier($file, '_original'),
                    'master_dim' => 'width',
                    'width' => $width * 2,
                    'new_image' =>  $this->append_identifier($file, '@2x')
                );
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $this->image_lib->clear();

            }

            // return memory limit to normal
            ini_set('memory_limit', $memory_limit);

        }
    }

    private function append_identifier($path, $identifier) {

        $pathinfo = pathinfo($path);

        return $pathinfo['dirname'] . '/' . $pathinfo['filename'] . $identifier . '.' . $pathinfo['extension'];
    }

    public function delete($filename, $delete_thumb = false) {

        @unlink($filename);

        if ($delete_thumb) {
            @unlink($this->append_identifier($filename, '_original'));
            @unlink($this->append_identifier($filename, '@2x'));
        }

    }

}