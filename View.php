<?php
defined('ABSPATH') || exit; ?>

<?php

$key = isset($key) ? (int) $key : '{key}';
$method = isset($condition['method']) && !empty($condition['method']) ? $condition['method'] : '';
$values = isset($condition['values']) && !empty($condition['values']) ? array_flip($condition['values']) : [];
$tags=[];
foreach($values as $id => $index){
    $tags[$id]= get_term($id, 'product_tag');
}
?>

<div class="condition-method flex-fill">
    <select class="form-control" name="conditions[<?php echo esc_attr($key); ?>][method]">
        <option value="in_list" <?php if ($method == 'in_list') echo "selected"; ?>><?php esc_html_e("In list", 'checkout-upsell-woocommerce'); ?></option>
        <option value="not_in_list" <?php if ($method == 'not_in_list') echo "selected"; ?>><?php esc_html_e("Not in list", 'checkout-upsell-woocommerce'); ?></option>
    </select>
</div>

<div class="condition-values w-75 ml-2">
    <select multiple class="select2-list" name="conditions[<?php echo esc_attr($key); ?>][values][]" data-list="tags"
            data-placeholder=" <?php esc_html_e("Choose tags", 'checkout-upsell-woocommerce'); ?>">
        <?php foreach ($tags as $tag) { ?>
            <option value="<?php echo esc_attr($tag->term_id); ?>" selected><?php echo esc_html($tag->name); ?></option>
        <?php } ?>
    </select>
</div>
