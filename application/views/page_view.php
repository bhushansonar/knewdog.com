<main>
    <section id="container">
        <div class="set_errors">
            <?php
            echo validation_errors();
            if ($this->session->flashdata('flash_message')) {
                echo '<div class="alert ' . $this->session->flashdata("flash_class") . '">';
                echo '<a class="close" data-dismiss="alert">&#215;</a>';
                echo $this->session->flashdata("flash_message");
                echo '</div>';
            }
            ?>
        </div>

        <?php echo cms_block($cms_block) ?>
    </section>
</main>