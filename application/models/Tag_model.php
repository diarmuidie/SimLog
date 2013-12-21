<?php
/**
 * Created by JetBrains PhpStorm.
 * User: diarmuid
 * Date: 07/10/2013
 * Time: 22:32
 * To change this template use File | Settings | File Templates.
 */

class Tag_model extends CI_Model {

    CONST TABLE = 'tag';
    CONST JOIN_TABLE = 'post_tag';

    function get_all_tags($in_use = False) {

        $query = $this->db
            ->select('id, tag')
            ->from(self::TABLE)
            ->group_by('tag')
            ->order_by('tag', 'asc')
            ->get();

        if ($in_use) {
            $this->db->join('post_tag', 'post_tag.tag_id = tag.id');
        }

        return $query->result_array();

    }

    function get_post_tags($post_id, $string = False) {

        $query = $this->db
            ->select('id, tag')
            ->from(self::TABLE)
            ->where('post_id', $post_id)
            ->join('post_tag', 'post_tag.tag_id = tag.id')
            ->group_by('tag')
            ->order_by('tag', 'asc')
            ->get();

        $results = $query->result_array();

        if ($string) {
            $return = False;
            foreach ($results as $result) {
                if (!$return) {
                    $return = $result['tag'];
                }
                $return .=  "," . $result['tag'];
            }
            return $return;
        }
        return $results;
    }

    function get_tag($tag) {

        $query = $this->db
            ->select('id')
            ->from(self::TABLE)
            ->where('tag', $tag)
            ->get();
        return $query->row_array();

    }

    function add_tags($tag_string, $post_id) {

        // Unlink from all existing tags
        $this->unlink_post($post_id);

        // Check if any tags were sent
        if (strlen($tag_string) > 0) {

            $tags = explode(',', $tag_string);

            // Relink to all new tags
            foreach ($tags as $tag) {
                $this->link_tag($tag, $post_id);
            }
        }
    }

    function add_tag($tag) {

        $this->db->insert(self::TABLE, array('tag' => $tag));

        return $this->db->insert_id();

    }

    function link_tag($tag, $post_id) {

        if ($query = $this->get_tag($tag)) {
            $tag_id = $query['id'];
        } else {
            $tag_id = $this->add_tag($tag);
        }

        if (!$this->get_link($post_id, $tag_id)) {
            $this->db->insert(self::JOIN_TABLE,
                array(
                    'tag_id' => $tag_id,
                    'post_id' => $post_id
                )
            );
            return $this->db->insert_id();
        }

    }

    function unlink_post($post_id) {

        $this->db->where('post_id', $post_id);
        $this->db->delete(self::JOIN_TABLE);

    }

    function get_link($post_id, $tag_id) {
        $query = $this->db
            ->from(self::JOIN_TABLE)
            ->where('tag_id', $tag_id)
            ->where('post_id', $post_id)
            ->get();
        return $query->row_array();
    }

    function delete_tag() {

    }

}