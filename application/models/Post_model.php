<?php
/**
 * Created by JetBrains PhpStorm.
 * User: diarmuid
 * Date: 07/10/2013
 * Time: 22:32
 * To change this template use File | Settings | File Templates.
 */

class Post_model extends CI_Model {

    CONST TABLE = 'post';

    function __construct() {
        parent::__construct();
        $this->load->model('Tag_model');
    }

    function get_entries($page = 0, $count = 30) {

        $query = $this->db
            ->select('title, slug, published, edited, id')
            ->from(self::TABLE)
            ->where('published <=', date('Y-m-d H:i:s'))
            ->order_by('published', "desc")
            ->limit($count, $page * $count)
            ->get();

        return $query->result_array();

    }

    function get_draft_entries($page = 0, $count = 30) {

        $query = $this->db
            ->select('title, slug, published, edited, id')
            ->from(self::TABLE)
            ->where('published >=', date('Y-m-d H:i:s'))
            ->or_where('published IS NULL', null, false)
            ->order_by('edited', "desc")
            ->limit($count, $page * $count)
            ->get();

        return $query->result_array();

    }

    function get_entry_id($id) {

        $query = $this->db
            ->from(self::TABLE)
            ->where('id', $id)
            ->get();

        return $query->row_array();

    }

    function get_entry_slug($slug, $published = TRUE) {

        $this->db
            ->from(self::TABLE)
            ->where('slug', $slug);

        if ($published === TRUE) {
            $this->db->where('published <=', date('Y-m-d H:i:s'))
                ->where('published IS NOT NULL', null, false);
        }

        $query = $this->db->get();

        return $query->row_array();

    }

    function add_entry($data) {

        $data['edited'] = date('Y-m-d H:i:s');
        $data['added'] = date('Y-m-d H:i:s');

        $this->db->insert(self::TABLE, $data);

        return $this->db->insert_id();

    }

    function update_entry($data) {

        $query = $this->db->where('id', $data['id'])
            ->update(self::TABLE, $data);

        return $query;

    }

    function delete_entry($id) {

        $this->db->delete(self::TABLE, array('id' => $id));

    }

    function check_unique_slug($slug, $exclude_id = Null) {

        $this->db
            ->from(self::TABLE)
            ->where('slug', $slug);

        if ($exclude_id) {
            $this->db
                ->where('id !=', $exclude_id);
        }

        $query = $this->db
            ->count_all_results();

        if ($query > 0) {
            return FALSE;
        }

        return TRUE;

    }

    function markdown($markdown, $extra = FALSE) {

        if ($extra) {
            $markdownParser = new \dflydev\markdown\MarkdownExtraParser();
        } else {
            $markdownParser = new \dflydev\markdown\MarkdownParser();
        }

        return $markdownParser->transformMarkdown($markdown);

    }
}