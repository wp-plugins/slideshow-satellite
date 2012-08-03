<?php

class SatelliteFormHelper extends SatellitePlugin {

    public function display($newfields, $model) {
        foreach ($newfields as $value) {
            switch ( $value['type'] ) {
                case 'select':
                    echo $this -> select($model.'.'.$value[id], $value);
                    break;
                case 'text':
                    echo $this -> text($model.'.'.$value[id], $value);
                    break;
                case 'textarea':
                    echo $this -> textarea($model.'.'.$value[id], $value);
                    break;
            }
        }
        
    }
    
    function hidden($name = '', $args = array()) {
        global $wpcoHtml;
        $defaults = array(
            'value' => (empty($args['value'])) ? $this->Html->field_value($name) : $args['value'],
        );
        $r = wp_parse_args($args, $defaults);
        extract($r, EXTR_SKIP);
        ob_start();
        ?><input type="hidden" name="<?php echo $this->Html->field_name($name); ?>" value="<?php echo $value; ?>" id="<?php echo $name; ?>" /><?php
        $hidden = ob_get_clean();
        return $hidden;
    }

    function text($name = '', $args = array()) {
        $Html = new SatelliteHtmlHelper;

        $defaults = array(
            'id' => (empty($args['id'])) ? $name : $args['id'],
            'width' => '100%',
            'class' => "widefat",
            'error' => true,
            'value' => (empty($args['value'])) ? $Html -> field_value($name) : $args['value'],
            'autocomplete' => "on",
        );

        $r = wp_parse_args($args, $defaults);
        extract($r, EXTR_SKIP);

        $this->debug($this);
        $Html = new SatelliteHtmlHelper;

        ob_start();
        ?>
        <?php echo $Html->field_value($name); ?>
            <tr>
                <th><label><strong><?php echo $r['name']; ?></strong></label></th>
                <td>
                    <input style="width:400px;" class="<?php echo $r['class']; ?>"name="<?php echo $Html->field_name($name); ?>" id="<?php echo $r['id']; ?>" type="<?php echo $r['type']; ?>" value="<?php echo ($r['value']); ?>" />
                    <?php echo ($error == true) ? '<div style="color:red;">' . $Html->field_error($name) . '</div>' : ''; ?>
                    <span class="howto"><?php echo($r['desc']); ?></span>
                </td>
            </tr>
        
        <!--input class="<?php echo $class; ?>" type="text" autocomplete="<?php echo $autocomplete; ?>" style="width:<?php echo $width; ?>" name="<?php echo $Html->field_name($name); ?>" value="<?php echo $value; ?>" id="<?php echo $id; ?>" /--><?php

        $text = ob_get_clean();
        return $text;
    }

    function textarea($name = '', $args = array()) {
        $defaults = array(
            'error' => true,
            'width' => '100%',
            'class' => "widefat",
            'rows' => 4,
            'cols' => "100%",
        );
        
        $r = wp_parse_args($args, $defaults);
        extract($r, EXTR_SKIP);
        $Html = new SatelliteHtmlHelper;
        
        ob_start();
        ?>
            <tr>
                <th><label><strong><?php echo $r['name']; ?></strong></label></th>
                <td>
                    <textarea class="<?php echo $class; ?>" name="<?php echo $Html->field_name($name); ?>" rows="<?php echo $rows; ?>" style="width:<?php echo $width; ?>;" cols="<?php echo $cols; ?>" id="<?php echo $name; ?>"><?php echo ($r['value']); ?></textarea>
                    <span class="howto"><?php echo($r['desc']); ?></span>
                </td>
            </tr>
            <?php
        if ($error == true) {
            echo $Html->field_error($name);
        }

        $textarea = ob_get_clean();
        return $textarea;
    }
    
    function select($name = '', $args = array()){
        $Html = new SatelliteHtmlHelper;
        $defaults = array(
            'error' => true,
            'class' => "widefat",
            'width' => "140",
            //'value' => (empty($args['value'])) ? '' : $args['value'],
        );
        
        $r = wp_parse_args($args, $defaults);
        extract($r, EXTR_SKIP);
        
        ob_start();
        ?>
            <tr>
                <th><label><strong><?php echo $r['name']; ?></strong></label></th>
                <td >
                    <select class="<?php echo $class; ?>" style="width:<?php echo $width; ?>px;" name="<?php echo $Html->field_name($name); ?>" id="<?php echo $r['id']; ?>">
                <?php if ( ! $Html->findInOptions($r['std'],$r['options']) ) : ?>
                        <option value="" ><?php echo($r['std']); ?></option> 
                <?php endif; ?>
                <?php foreach ($r['options'] as $option) : ?>
                        <option value="<?php echo($option['id']); ?>"<?php 
                        if ( $r['value'] == $option['id'] ) { echo ' selected=selected'; }
                        elseif ( $r['value'] == null && $r['std'] == $option['id'] ) { echo ' selected=selected'; }
                        echo ">".$option['title']; 
                        ?></option>
                 <?php endforeach; ?>
                    </select>
                    <span class="howto"><?php echo($r['desc']); ?></span>
                </td>
            </tr>
    <?php 
        $select = ob_get_clean();
        return $select;
    }    
    

    function submit($name = '', $args = array()) {
        $defaults = array('class' => "button-primary");
        $r = wp_parse_args($args, $defaults);
        extract($r, EXTR_SKIP);

        ob_start();
        ?><input class="<?php echo $class; ?>" type="submit" name="<?php echo $this->Html->sanitize($name); ?>" value="<?php echo $name; ?>" /><?php
        $submit = ob_get_clean();
        return $submit;
    }

}
?>