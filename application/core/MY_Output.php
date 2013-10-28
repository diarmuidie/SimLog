<?php

class MY_Output extends CI_Output
{
    /**
     * Clears all cache from the cache directory
     */
    public function clear_all_cache()
    {
        $CI =& get_instance();
        $path = $CI->config->item('cache_path');

        $cache_path = ($path == '') ? APPPATH . 'cache/' : $path;

        $handle = opendir($cache_path);

        while (($file = readdir($handle)) !== false) {
            //Leave the directory protection alone
            if ($file != '.htaccess' && $file != 'index.html') {
                @unlink($cache_path . '/' . $file);
            }
        }

        closedir($handle);
    }

    /**
     * Write Cache
     *
     * @param	string	$output	Output data to cache
     * @return	void
     */
    public function _write_cache($output)
    {
        $CI =& get_instance();
        $path = $CI->config->item('cache_path');
        $cache_path = ($path === '') ? APPPATH.'cache/' : $path;

        if ( ! is_dir($cache_path) OR ! is_really_writable($cache_path))
        {
            log_message('error', 'Unable to write cache file: '.$cache_path);
            return;
        }

        $uri =	$CI->config->item('base_url').
            $CI->config->item('index_page').
            $CI->uri->uri_string();

        $cache_path .= md5($uri);

        if ( ! $fp = @fopen($cache_path, FOPEN_WRITE_CREATE_DESTRUCTIVE))
        {
            log_message('error', 'Unable to write cache file: '.$cache_path);
            return;
        }

        $expire = time() + ($this->cache_expiration * 60);

        // Put together our serialized info.
        $cache_info = serialize(array(
                'expire'	=> $expire,
                'headers'	=> $this->headers,
                'uri'       => $uri
            ));

        if (flock($fp, LOCK_EX))
        {
            fwrite($fp, $cache_info.'ENDCI--->'.$output);
            flock($fp, LOCK_UN);
        }
        else
        {
            log_message('error', 'Unable to secure a file lock for file at: '.$cache_path);
            return;
        }
        fclose($fp);
        @chmod($cache_path, FILE_WRITE_MODE);

        log_message('debug', 'Cache file written: '.$cache_path);

        // Send HTTP cache-control headers to browser to match file cache settings.
        $this->set_cache_header($_SERVER['REQUEST_TIME'], $expire);
    }

}