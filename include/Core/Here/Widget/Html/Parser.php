<?php
/**
 *
 * @author ShadowMan
 */

class Widget_Html_Parser extends Abstract_Widget {
    public function article($data, array $mapping = array(), $template = 'article.tpl') {
        if (is_callable($data)) {
            $data = $data();
        }

        $s = file_get_contents('include/Theme/default/templates/article.tpl');

        $r = Manager_Widget::widget('template')->compile($s);

        echo "<pre>";
        echo htmlentities($r);
        echo "</pre>";
    }
}

?>