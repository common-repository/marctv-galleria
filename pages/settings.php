<?php
if (!defined('ABSPATH')) {
    die(__('Cheatin&#8217; uh?'));
}
?>
<div class="wrap">
    <h2>MarcTV Galleria</h2>

    <form method="post" action="options.php">
        <?php settings_fields($this->pluginPrefix . '-settings-group'); ?>
        <?php do_settings_sections($this->pluginPrefix . '-settings-group'); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"> <?php echo __('image size', 'marctv-galleria'); ?></th>
                <td>
                    <p><label for="marctv-galleria-size">
                            <?php echo __('Choose the image size for the galleria images.', 'marctv-galleria'); ?>
                        </label></p>
                    <p>
                        <select name="marctv-galleria-size">
                            <?php foreach (array('thumbnail' => 'Thumbnail', 'medium' => 'Medium', 'large' => 'Large', 'full' => 'Original') as $k => $v) { ?>
                                <option <?php selected(get_option($this->pluginPrefix .  '-size',$this->defaults['imagesize']), $k); ?>
                                    value="<?php echo esc_attr($k) ?>"><?php esc_html_e($v, 'marctv-galleria') ?></option>
                            <?php } ?>
                        </select>
                    </p>
                    </fieldset>

                </td>
            </tr>



            <tr valign="top">
                <th scope="row"> <?php echo __('breakpoint', 'marctv-galleria'); ?></th>
                <td>
                    <p><label for="marctv-galleria-breakpoint">
                            <?php echo __('Choose the breakpoint in pixels.', 'marctv-galleria'); ?>
                        </label></p>
                    <p>
                        <input class="small-text" name="marctv-galleria-breakpoint" value="<?php echo get_option($this->pluginPrefix .  '-breakpoint',$this->defaults['breakpoint']) ?>">px
                    </p>
                    </fieldset>

                </td>
            </tr>



            <tr valign="top">
                <th scope="row"> <?php echo __('breakpoint image', 'marctv-galleria'); ?></th>
                <td>
                    <p><label for="marctv-galleria-size-break">
                            <?php echo __('Choose the image size for the galleria images smaller than the breakpoint.', 'marctv-galleria'); ?>
                        </label></p>
                    <p>
                        <select name="marctv-galleria-breaksize">
                            <?php foreach (array('thumbnail' => 'Thumbnail', 'medium' => 'Medium', 'large' => 'Large', 'full' => 'Original') as $k => $v) { ?>
                                <option <?php selected(get_option($this->pluginPrefix .  '-breaksize',$this->defaults['breaksize']), $k); ?>
                                    value="<?php echo esc_attr($k) ?>"><?php esc_html_e($v, 'marctv-galleria') ?></option>
                            <?php } ?>
                        </select>
                    </p>
                    </fieldset>

                </td>
            </tr>

            <tr valign="top">
                <th scope="row"> <?php echo __('breakpoint fullscreen', 'marctv-galleria'); ?></th>
                <td>
                    <p><label for="marctv-galleria-size">
                            <?php echo __('Choose the image size for the galleria fullscreen image small than the breakpoint.', 'marctv-galleria'); ?>
                        </label></p>
                    <p>
                        <select name="marctv-galleria-fullscreen">
                            <?php foreach (array('thumbnail' => 'Thumbnail', 'medium' => 'Medium', 'large' => 'Large', 'full' => 'Original') as $k => $v) { ?>
                                <option <?php selected(get_option($this->pluginPrefix .  '-fullscreen',$this->defaults['fullscreen']), $k); ?>
                                    value="<?php echo esc_attr($k) ?>"><?php esc_html_e($v, 'marctv-galleria') ?></option>
                            <?php } ?>
                        </select>
                    </p>
                    </fieldset>

                </td>
            </tr>

        </table>

        <?php submit_button(); ?>

    </form>
</div>
