<?php $temp = $this->apps->get_template_content();?>
<div class="footer">
    <div class="footer-inner">
        <!-- #section:basics/footer -->
        <div class="footer-content">
            <span class="bigger-120">
                <span class="blue bolder"><?php echo isset($temp->footer_text)?$temp->footer_text:'Text Footer'?></span>
                <?php echo isset($temp->copyright)?$temp->copyright:'@Copyright'?>
            </span>
        </div>

        <!-- /section:basics/footer -->
    </div>
</div>