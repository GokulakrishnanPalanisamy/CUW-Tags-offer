<?php

use CUW\App\Modules\Conditions\Base;


defined('ABSPATH') || exit;

class CUW_tag extends Base
{
    private static $tag_ids;

    public function template($data = [], $print = false)
    {
        ob_start();
        extract($data); // Extract the data array into individual variables
        include 'View.php';
        $view = ob_get_clean();
        if ($print) {
            echo $view; // Print the view if $print is true
        }
        return $view;
    }

    public function check($condition, $data)
    {
        if (!isset($condition['values']) || !isset($condition['method'])) {
            return false;
        }

        if (!isset(self::$tag_ids)) {
            $tag_ids = [];
            foreach ($data['products'] as $product) {
                $tag_ids = array_merge($tag_ids, self::getProductTagIds($product['id']));
            }
            self::$category_ids = array_unique($tag_ids);
        }

        return self::checkLists($condition['values'], self::$tag_ids, $condition['method']);
    }

    public static function getProductTagIds($object_or_id)
    {
        $product = self::getProduct($object_or_id);
        if (is_object($product) && method_exists($product, 'get_parent_id')) {
            return $product->get_tag_ids();
        }
        return [];
    }

    public static function getProduct($object_or_id = false)
    {
        if (is_object($object_or_id) && is_a($object_or_id, '\WC_Product')) {
            return $object_or_id;
        } elseif (function_exists('wc_get_product') && $product = wc_get_product($object_or_id)) {
            return $product;
        }
        return false;
    }




}