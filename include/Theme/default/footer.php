    <footer class="container">
        <div id="footer-copyright">
            <p>Proudly Powered By <a href="https://github.com/JShadowMan/here" target="_blank">Here</a>. Distributed Under The <a href="<?php echo Request::getFullUrl('/license.html'); ?>" target="_blank">MIT</a> license.</p>
            <p id="ICP-filing"><?php Common::eDefault(Manager_Widget::widget('options')->ICPFiling, 
                    Manager_Widget::widget('parser')->a(Manager_Widget::widget('options')->ICPFilingHref, Manager_Widget::widget('options')->ICPFiling))?></p>
        </div>
        <?php Manager_Plugin::hook('index@footer') ?>
    </footer>
</body>
</html>